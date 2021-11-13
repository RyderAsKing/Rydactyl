<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nodes', function (Blueprint $table) {
            //
            $table->string('uuid');
            $table->string('node_fqdn');
            $table->string('description');
            $table->integer('memory_allocated');
            $table->integer('disk_allocated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nodes', function (Blueprint $table) {
            //
            $table->dropColumn('uuid');
            $table->dropColumn('node_fqdn');
            $table->dropColumn('description');
            $table->dropColumn('memory_allocated');
            $table->dropColumn('disk_allocated');
        });
    }
}
