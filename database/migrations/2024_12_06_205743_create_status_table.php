<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre del estado
            $table->unsignedBigInteger('events_id'); // Relación con la tabla events
            $table->timestamps();

            // Relación con la tabla events
            $table->foreign('events_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('status');
    }
}
