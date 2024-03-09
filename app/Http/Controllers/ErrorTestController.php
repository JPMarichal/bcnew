<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorTestController extends Controller
{
    // Método para probar el error 400 Bad Request
    public static function badRequest()
    {
        abort(400, 'Error 400: Solicitud Incorrecta.');
    }

    // Método para probar el error 401 Unauthorized
    public static function unauthorized()
    {
        abort(401, 'Error 401: No Autorizado.');
    }

    // Método para probar el error 403 Forbidden
    public static function forbidden()
    {
        abort(403, 'Error 403: Prohibido.');
    }

    // Método para probar el error 404 Not Found
    public static function notFound()
    {
        abort(404, 'Error 404: Página No Encontrada.');
    }

    // Método para probar el error 405 Method Not Allowed
    public static function methodNotAllowed()
    {
        abort(405, 'Error 405: Método No Permitido.');
    }

    // Método para probar el error 408 Request Timeout
    public static function requestTimeout()
    {
        abort(408, 'Error 408: Tiempo de Solicitud Excedido.');
    }

    // Método para probar el error 429 Too Many Requests
    public static function tooManyRequests()
    {
        abort(429, 'Error 429: Demasiadas Solicitudes.');
    }

    // Método para probar el error 500 Internal Server Error
    public static function internalServerError()
    {
        abort(500, 'Error 500: Error Interno del Servidor.');
    }

    // Método para probar el error 501 Not Implemented
    public static function notImplemented()
    {
        abort(501, 'Error 501: No Implementado.');
    }

    // Método para probar el error 502 Bad Gateway
    public static function badGateway()
    {
        abort(502, 'Error 502: Mal Gateway.');
    }

    // Método para probar el error 503 Service Unavailable
    public static function serviceUnavailable()
    {
        abort(503, 'Error 503: Servicio No Disponible.');
    }

    // Método para probar el error 504 Gateway Timeout
    public static function gatewayTimeout()
    {
        abort(504, 'Error 504: Tiempo de Espera del Gateway Excedido.');
    }
}
