<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id'); // Usuario que sigue
            $table->unsignedBigInteger('followed_id'); // Usuario que es seguido
            $table->timestamp('created_at')->useCurrent(); // Fecha en que se sigue

            // Relación con la tabla users (follower)
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla users (followed)
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
