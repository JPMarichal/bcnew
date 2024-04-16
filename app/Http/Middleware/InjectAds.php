<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectAds
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Aseguramos que solo actúe en la ruta deseada y que la respuesta sea exitosa
        if ($request->is('blog/*') && $response instanceof \Illuminate\Http\Response && $response->isSuccessful()) {
            $content = $response->getContent();
            $adFrequency = env('AD_FREQUENCY', 3); // Frecuencia de los anuncios
            $headerCount = 0;
            $firstAdPlaced = false;

            // Dividimos el contenido en líneas
            $lines = explode("\n", $content);
            $newContent = [];
            foreach ($lines as $line) {
                // Modificamos la expresión regular para incluir cualquier atributo en las etiquetas de encabezado
                if (preg_match('/<h[2-6][^>]*>/', $line)) {
                    $headerCount++;
                    if (!$firstAdPlaced || $headerCount % $adFrequency == 0) {
                        $newContent[] = view('components.ad-placeholder')->render();
                        $firstAdPlaced = true;
                    }
                }
                $newContent[] = $line;
            }
            // Reconstruimos el contenido
            $content = implode("\n", $newContent);
            $response->setContent($content);
        }

        return $response;
    }
}
