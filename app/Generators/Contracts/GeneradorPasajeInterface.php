<?php

namespace App\Generators\Contracts;

interface GeneradorPasajeInterface
{
    public function generar($versiculos, $referenciaFinal, $titulo = null);
}
