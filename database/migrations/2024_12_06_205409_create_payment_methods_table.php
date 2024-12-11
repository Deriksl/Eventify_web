<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type'); // Tipo de pago, e.g., debit, credit, PayPal
            $table->text('details'); // Detalles del pago, encriptados
            $table->timestamp('created_at')->useCurrent(); // Fecha de creación
            $table->unsignedBigInteger('user_id'); // Relación con el usuario

            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
