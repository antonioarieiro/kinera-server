<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('followers', function (Blueprint $table) {
            $table->string('name')->after('address')->nullable();
            $table->string('follow_name')->after('address')->nullable();
            $table->string('img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('followers', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('img');
            $table->dropColumn('follow_name');
        });
    }
}
