<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsColumnToSocialPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_post', function (Blueprint $table) {
            // Adiciona a coluna para armazenar o array de strings
            $table->text('urls')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_post', function (Blueprint $table) {
            // Remove a coluna 'tags' se ela existir
            $table->dropColumn('urls');
        });
    }
}
