<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectAds
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verifica si la ruta actual corresponde a la vista de detalle de blog
        if ($request->is('blog/*') && $response instanceof \Illuminate\Http\Response && $response->isSuccessful()) {
            $content = $response->getContent();

            // Divide el contenido en bloques para evitar blockquotes
            $blocks = preg_split('/(<blockquote.*?>.*?<\/blockquote>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
            $newContent = '';

            foreach ($blocks as $block) {
                // Si el bloque es un blockquote, añádelo sin modificaciones
                if (preg_match('/<blockquote.*?>.*?<\/blockquote>/is', $block)) {
                    $newContent .= $block;
                } else {
                    // Si no, inserta anuncios en los párrafos
                    $paragraphs = explode('</p>', $block);
                    foreach ($paragraphs as $index => $paragraph) {
                        $newContent .= $paragraph . '</p>';
                        if (rand(0, 4) === 2) {  // Probabilidad de 1 en 5 de insertar un anuncio
                            $newContent .= view('components.ad-placeholder')->render();
                        }
                    }
                }
            }
            $response->setContent($newContent);
        }

        return $response;
    }
}

