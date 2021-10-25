<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscordIdAndResourcesToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('discord_id');
            $table->integer('ram_balance');
            $table->integer('disk_balance');
            $table->integer('cpu_balance');
            $table->integer('slot_balance');
            $table->integer('coin_balance');
            $table->integer('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('discord_id');
            $table->dropColumn('ram_balance');
            $table->dropColumn('disk_balance');
            $table->dropColumn('cpu_balance');
            $table->dropColumn('slot_balance');
            $table->dropColumn('coin_balance');
            $table->dropColumn('type');
        });
    }
}
