<?php

namespace App\Factories;

use App\Generators\Contracts\GeneradorPasajeInterface;
use App\Generators\Escrituras\Pasajes\GeneradorTexto;
use App\Generators\Escrituras\Pasajes\GeneradorHtml;
use App\Generators\Escrituras\Pasajes\GeneradorJson;
use App\Generators\Escrituras\Pasajes\GeneradorPpt;

// Asegúrate de incluir todos los generadores que implementes.

class GeneradorPasajeFactory
{
    /**
     * Crea una instancia de generador de pasaje basado en el formato especificado.
     *
     * @param  string  $formato El formato deseado para la salida.
     * @return GeneradorPasajeInterface
     * @throws \Exception Si el formato no es soportado.
     */
    public static function crear($formato): GeneradorPasajeInterface
    {
        switch (strtolower($formato)) {
            case 'texto':
                return new GeneradorTexto();
            case 'html':
                return new GeneradorHtml();
            case 'json':
                return new GeneradorJson();
            case 'ppt':
                return new GeneradorPpt();
            default:
                throw new \Exception("Formato de salida no soportado: {$formato}");
        }
    }
}
