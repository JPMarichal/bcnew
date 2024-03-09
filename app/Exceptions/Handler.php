<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception): Response
    {
        // Verificar si la excepción es del tipo HttpException, lo cual incluye errores 404, 500, etc.
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode(); // Obtener el código de estado HTTP de la excepción
            // Verifica si existe una vista para este código de estado HTTP
            if (!view()->exists("errors.{$statusCode}")) {
                // Usa la vista genérica si no existe una específica para este código de estado HTTP
                return response()->view('errors.generic', ['exception' => $exception], $statusCode);
            }
        }

        // Delegar al método render predeterminado para cualquier otra excepción no manejada específicamente aquí
        return parent::render($request, $exception);
    }
}
