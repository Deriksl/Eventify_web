<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_pages', function (Blueprint $table) {
            $table->id(); // Crea la columna 'id' como PRIMARY KEY
            $table->binary('custom_logo')->nullable(); // Crea la columna 'custom_logo' de tipo blob, nullable
            $table->binary('custom_banner')->nullable(); // Crea la columna 'custom_banner' de tipo blob, nullable
            $table->text('custom_description')->nullable(); // Crea la columna 'custom_description' de tipo text, nullable
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // Crea la columna 'event_id' y establece una clave foránea con la tabla 'events'
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_pages');
    }
}
