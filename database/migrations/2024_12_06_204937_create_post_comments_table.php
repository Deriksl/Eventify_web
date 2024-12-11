<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_post_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment_text'); // Comentario del post
            $table->float('rating', 2, 1); // Calificación de 1 a 5
            $table->timestamp('created_at')->useCurrent(); // Fecha de creación
            $table->unsignedBigInteger('post_id'); // Relación con el post
            $table->unsignedBigInteger('user_id'); // Relación con el usuario

            // Relación con la tabla posts
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
