<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ListCustomCommands extends Command
{
    protected $signature = 'custom:commands';
    protected $description = 'Lista todos los comandos personalizados';

    public function handle()
    {
        $this->line('');
        $this->line("<fg=green;options=bold>Lista de comandos personalizados:</>");
        $this->line("<fg=yellow;options=bold>--------------------------------</>");


        $customNamespace = 'App\Console\Commands';
        $allCommands = Artisan::all();

        foreach ($allCommands as $command) {
            if (str_starts_with(get_class($command), $customNamespace)) {
                // Nombre del comando en negritas y verde, descripción en texto plano (blanco por defecto)
                $this->line("<fg=bright-green>{$command->getName()}</><fg=bright-red> -> </><fg=default>{$command->getDescription()}</>");
            }
        }

        $this->line('');
    }
}
