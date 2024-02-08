<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSocialPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_post', function (Blueprint $table) {
            $table->boolean('is_rankings')->nullable();
            $table->boolean('is_festival')->nullable();
            $table->integer('event_id')->nullable();
            $table->text('tag')->nullable();
            $table->string('categorie')->nullable();
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
            $table->dropColumn('is_rankings');
            $table->dropColumn('is_festival');
            $table->dropColumn('event_id');
            $table->dropColumn('tag');
            $table->dropColumn('categorie');
        });
    }
}
