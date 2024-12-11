<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_user_roles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // Rol del usuario
            $table->unsignedBigInteger('user_id'); // Relación con la tabla users
            $table->unsignedBigInteger('event_id'); // Relación con la tabla events
            $table->timestamps();

            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relación con la tabla events
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
