<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeticionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticiones', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('baliza');
            $table->timestamps();
        });
        Schema::table('peticiones',function(Blueprint $table){
           $table->foreign('user')->references('email')->on('users');
            $table->foreign('baliza')->references('id')->on('baliza');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peticiones');
    }
}
