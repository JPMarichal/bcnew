<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectAds
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('blog/*') && $response instanceof \Illuminate\Http\Response && $response->isSuccessful()) {
            $content = $response->getContent();
            $adFrequency = env('AD_FREQUENCY', 4); // Utiliza una variable de entorno o un valor predeterminado

            // Asegurarse de que solo modificamos el contenido dentro de la sección 'blog_content'
            $content = preg_replace_callback(
                '/(<section id="blog_content" class="[^"]+">)(.*?)(<\/section>)/is',
                function ($matches) use ($adFrequency) {
                    $innerContent = $matches[2]; // Contenido dentro de blog_content
                    $headerCount = 0;
                    $firstAdPlaced = false;
                    $newInnerContent = '';

                    // Evitar modificar contenido dentro de blockquotes y considerar tags de WordPress
                    $blocks = preg_split('/(<blockquote.*?>.*?<\/blockquote>|<!-- \/wp:paragraph -->)/is', $innerContent, -1, PREG_SPLIT_DELIM_CAPTURE);
                    foreach ($blocks as $block) {
                        if (preg_match('/<blockquote.*?>.*?<\/blockquote>/is', $block) || str_contains($block, '<!-- /wp:paragraph -->')) {
                            $newInnerContent .= $block;
                        } else {
                            $headerPattern = '/(<h[1-6]>.*?<\/h[1-6]>)/is';
                            $paragraphs = preg_split($headerPattern, $block, -1, PREG_SPLIT_DELIM_CAPTURE);
                            foreach ($paragraphs as $paragraph) {
                                if (preg_match($headerPattern, $paragraph)) {
                                    $headerCount++;
                                    if (!$firstAdPlaced || $headerCount % $adFrequency == 0) {
                                        $newInnerContent .= view('components.ad-placeholder')->render();
                                        $firstAdPlaced = true;
                                    }
                                }
                                $newInnerContent .= $paragraph;
                            }
                        }
                    }
                    return $matches[1] . $newInnerContent . $matches[3]; // Reconstruye la sección con anuncios insertados
                },
                $content
            );

            $response->setContent($content);
        }

        return $response;
    }
}
