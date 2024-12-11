<?php

// database/migrations/xxxx_xx_xx_create_event_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventUserTable extends Migration
{
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->id(); // Agrega un campo de ID para la tabla intermedia
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Llave foránea para la relación con users
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Llave foránea para la relación con events
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_user');
    }
}

