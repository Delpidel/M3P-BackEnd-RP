<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliationsTable extends Migration
{

    public function up()
    {
        Schema::create('avaliations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('age');
            $table->date('date');
            $table->float('weight');
            $table->float('height');
            $table->text('observations_to_student')->nullable();
            $table->text('observations_to_nutritionist')->nullable();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
            $table->integer('torax');
            $table->integer('braco_direito');
            $table->integer('braco_esquerdo');
            $table->integer('cintura');
            $table->integer('antebraco_esquerdo');
            $table->integer('antebraco_direito');
            $table->integer('abdome');
            $table->integer('coxa_direita');
            $table->integer('coxa_esquerda');
            $table->integer('quadril');
            $table->integer('panturrilha_direita');
            $table->integer('panturilha_esquerda');
            $table->integer('punho');
            $table->integer('b_femoral_direito');
            $table->integer('b_femoral_esquerdo');
            $table->timestamps();


        });
    }


    public function down()
    {
        Schema::dropIfExists('avaliations');
    }
}
