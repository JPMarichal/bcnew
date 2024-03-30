<?php

namespace App\Services;

use App\Factories\GeneradorPasajeFactory;
use App\Models\Escrituras\Versiculo;

class PasajeService
{
    public function obtenerPasajeFormateado($referencia, $formato = 'texto', $titulo = null)
    {
        // Mapeo de nombres para traducir nombres de libros a su nombre canónico
        $mapeoNombres = [
            'dyc' => 'Secciones',
            'doctrina y convenios' => 'Secciones',
            'dyC' => 'Secciones',
        ];

        // Función de mapeo para traducir nombres de libros usando el mapeo
        $traducirNombreLibro = function ($nombreLibro) use ($mapeoNombres) {
            $nombreLibro = strtolower($nombreLibro); // Convierte a minúsculas para la búsqueda
            return $mapeoNombres[$nombreLibro] ?? $nombreLibro;
        };

        preg_match('/^(.*?)(\d+:\d+(-\d+)?$)/', $referencia, $matches);
        $nombreLibro = trim($matches[1]);
        $nombreLibroTraducido = $traducirNombreLibro($nombreLibro);
        [$capitulo, $versiculoRango] = explode(':', $matches[2]);
        [$versiculoInicio, $versiculoFin] = explode('-', $versiculoRango) + [1 => null];

        $versiculoFin = $versiculoFin ?? $versiculoInicio;

        $versiculos = Versiculo::whereHas('capitulo', function ($query) use ($nombreLibroTraducido, $capitulo) {
            $query->whereHas('libro', function ($query) use ($nombreLibroTraducido) {
                $query->where('nombre', '=', $nombreLibroTraducido);
            })->where('num_capitulo', '=', $capitulo);
        })
            ->whereBetween('num_versiculo', [$versiculoInicio, $versiculoFin])
            ->orderBy('num_versiculo', 'asc')
            ->get();

        if ($versiculos->isEmpty()) {
            return "No hay resultados para esa referencia.";
        }

        // Ajusta el versículo final basado en los versículos disponibles
        $versiculoFinalReal = $versiculos->last()->num_versiculo;

        // Usa la fábrica para obtener el generador de formato adecuado
        $generador = GeneradorPasajeFactory::crear($formato);

        // Genera y devuelve la salida formateada
        if ($versiculoInicio == $versiculoFinalReal) {
            return $generador->generar($versiculos, "{$nombreLibro} {$capitulo}:{$versiculoInicio}", $titulo);
        } else {
            return $generador->generar($versiculos, "{$nombreLibro} {$capitulo}:{$versiculoInicio}–{$versiculoFinalReal}", $titulo);
        }
    }
}
