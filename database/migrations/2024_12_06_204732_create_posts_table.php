<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título del post
            $table->text('body'); // Contenido del post
            $table->binary('img')->nullable(); // Imagen del post (puede ser nula)
            $table->timestamp('created_at')->useCurrent(); // Fecha de creación
            $table->unsignedBigInteger('user_id'); // Relación con el usuario


            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
