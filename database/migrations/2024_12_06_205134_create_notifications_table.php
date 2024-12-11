<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('message'); // Mensaje de la notificación
            $table->timestamp('sent_at')->useCurrent(); // Fecha y hora de envío
            $table->boolean('read_status'); // Estado de lectura (true o false)
            $table->unsignedBigInteger('user_id'); // Relación con el usuario
            $table->unsignedBigInteger('event_id'); // Relación con el evento
            $table->timestamps();

            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla events
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
