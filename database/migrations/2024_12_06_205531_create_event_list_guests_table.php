<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_event_list_guests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventListGuestsTable extends Migration
{
    public function up()
    {
        Schema::create('event_list_guests', function (Blueprint $table) {
            $table->id();
            $table->string('guests'); // Lista de invitados
            $table->unsignedBigInteger('tickets_id'); // Relación con la tabla tickets
            $table->unsignedBigInteger('events_pages_id'); // Relación con la tabla event_pages
            $table->timestamps();

            // Relación con la tabla tickets
            $table->foreign('tickets_id')->references('id')->on('tickets')->onDelete('cascade');

            // Relación con la tabla event_pages
            $table->foreign('events_pages_id')->references('id')->on('event_pages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_list_guests');
    }
}
