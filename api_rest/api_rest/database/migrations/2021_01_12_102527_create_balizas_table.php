<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baliza', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nombre');
            $table->string('provincia');
            $table->string('temperatura')->nullable();
            $table->string('precipitacion')->nullable();
            $table->float('humedad')->nullable();
            $table->float('velocidad')->nullable();
            $table->float('y');
            $table->float('z');
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
        Schema::dropIfExists('baliza');
    }
}
