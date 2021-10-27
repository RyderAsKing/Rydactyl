<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalResourcesToUsers extends Migration
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
            $table->integer('total_ram_balance')->default(0);
            $table->integer('total_disk_balance')->default(0);
            $table->integer('total_cpu_balance')->default(0);
            $table->integer('total_slot_balance')->default(0);
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
            $table->dropColumn('total_ram_balance');
            $table->dropColumn('total_disk_balance');
            $table->dropColumn('total_cpu_balance');
            $table->dropColumn('total_slot_balance');
        });
    }
}
