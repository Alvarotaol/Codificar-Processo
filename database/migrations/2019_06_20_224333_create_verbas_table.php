<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verbas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('valor', 10, 2);
            $table->integer('mes');

            $table->integer('deputado_id');
            $table->foreign('deputado_id')->references('id')->on('deputados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verbas');
    }
}
