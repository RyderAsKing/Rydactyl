<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('discord_id');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('discriminator');
            $table->string('refresh_token');
            $table->integer('type');
            $table->integer('ram_balance');
            $table->integer('disk_balance');
            $table->integer('cpu_balance');
            $table->integer('slot_balance');
            $table->integer('coin_balance');
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
        Schema::dropIfExists('users');
    }
}
