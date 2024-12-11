<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_tickets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->decimal('ticket_price', 8, 2)->nullable(); // Asegúrate de que pueda ser nulo
            $table->timestamp('purchase_date'); // Fecha de compra
            $table->string('ticket_code')->unique(); // Código del ticket
            $table->string('status'); // Estado del ticket, e.g., 'valid', 'used'
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
        Schema::dropIfExists('tickets');
    }
}
