<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizarOrdenPartesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partes:actualizar-orden';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el stored procedure ActualizarOrdenPartesPorPrimerCapitulo para actualizar el orden de las partes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Actualizando el orden de las partes...');
        DB::unprepared('CALL ActualizarOrdenPartesPorPrimerCapitulo()');
        $this->info('El orden de las partes ha sido actualizado exitosamente.');
    }
}
