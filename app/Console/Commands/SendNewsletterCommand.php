<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Mail;

class SendNewsletterCommand extends Command
{
    protected $signature = 'boletin:send';
    protected $description = 'Envía el boletín diario a todos los suscriptores';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = resolve(NewsletterController::class);
        $content = $controller->sendNewsletter();

        try {
            Mail::send([], [], function ($message) use ($content) {
                $message->to('jpmarichal@gmail.com')  // Asegúrate de cambiar esto por la lista de correos de suscriptores
                        ->subject('BC Boletín')
                        ->html($content);  // Usa el método html para establecer el cuerpo del correo
            });

            $this->info('El boletín ha sido enviado exitosamente.');
        } catch (\Exception $e) {
            $this->error('Hubo un error al enviar el boletín: ' . $e->getMessage());
        }
    }
}
