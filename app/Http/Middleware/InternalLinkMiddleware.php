<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Blog\Post;
use App\Models\InternalLink;
use DOMDocument;
use DOMXPath;

class InternalLinkMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('blog/*')) {
            $content = $response->getContent();
            $slug = $request->route('slug'); // Obtener el slug desde el parámetro de la ruta

            // Encontrar el post actual usando el slug
            $currentPost = Post::where('slug', $slug)->first();
            $currentPostId = $currentPost ? $currentPost->id : null;

            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new DOMXPath($dom);

            $links = InternalLink::with('linkedPost')->where('object', 'post')->get();

            foreach ($links as $link) {
                if (!empty($link->linkedPost) && $link->linked_id != $currentPostId) {
                    $nodes = $xpath->query("//text()[contains(., '{$link->texto}') and not(ancestor::a) and not(ancestor::h1) and not(ancestor::h2) and not(ancestor::h3) and not(ancestor::h4) and not(ancestor::h5) and not(ancestor::h6)]");
                    foreach ($nodes as $node) {
                        $foundText = $node->nodeValue;
                        $escapedText = preg_quote($link->texto, '/');
                        $replacementHTML = '<a href="' . htmlspecialchars(url("/blog/{$link->linkedPost->slug}"), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($link->texto, ENT_QUOTES, 'UTF-8') . '</a>';
                        $replacedText = preg_replace("/\b$escapedText\b/u", $replacementHTML, $foundText);

                        $newNode = $dom->createDocumentFragment();
                        try {
                            $newNode->appendXML($replacedText);
                            $node->parentNode->replaceChild($newNode, $node);
                        } catch (\Exception $e) {
                            error_log('Error appending XML: ' . $e->getMessage());
                        }
                    }
                }
            }

            $content = $dom->saveHTML();
            $response->setContent($content);
        }

        return $response;
    }
}
