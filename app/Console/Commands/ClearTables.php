<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTables extends Command
{
    protected $signature = 'db:clear'; // Comando personalizado
    protected $description = 'Vaciar todas las tablas de la base de datos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Desactivar las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Vaciar las tablas
        DB::table('users')->truncate();
        DB::table('password_reset_tokens')->truncate();
        DB::table('sessions')->truncate();
        DB::table('events')->truncate();
        DB::table('comments')->truncate();
        DB::table('tickets')->truncate();

        // Activar las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Las tablas han sido vaciadas correctamente.');

    }

}
