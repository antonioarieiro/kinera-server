<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('social_post')->onDelete('cascade');
            $table->text('content');
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('user_profile')->onDelete('cascade');
            $table->string('img')->nullable();
            $table->string('name')->nullable();
            $table->integer('parent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comment');
    }
}
