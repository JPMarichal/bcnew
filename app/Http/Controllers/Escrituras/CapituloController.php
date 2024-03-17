<?php

namespace App\Http\Controllers\Escrituras;

use App\Http\Controllers\Controller;
use App\Models\Escrituras\Capitulo;
use Illuminate\Http\Request;

class CapituloController extends Controller
{
    /**
     * Muestra la lista de capítulos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aquí puedes añadir lógica para mostrar todos los capítulos, si es necesario.
    }

    /**
     * Muestra el detalle de un capítulo específico basado en su nombre de referencia.
     *
     * @param  string  $referencia
     * @return \Illuminate\Http\Response
     */
    public function show($referencia)
    {
        // Buscar el capítulo por su campo de referencia
        $capitulo = Capitulo::where('referencia', $referencia)->firstOrFail();

        // Retornar una vista con los detalles del capítulo
        // Asumiendo que tienes una vista llamada 'escrituras.capitulo.show' y pasas el capítulo a la vista
        return view('escrituras.capitulos.show', compact('capitulo'));
    }
}
