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

            $table->unsignedBigInteger('back');
            $table->foreign('back')->references('id')->on('files');
            $table->unsignedBigInteger('front');
            $table->foreign('front')->references('id')->on('files');
            $table->unsignedBigInteger('left');
            $table->foreign('left')->references('id')->on('files');
            $table->unsignedBigInteger('right');
            $table->foreign('right')->references('id')->on('files');

            $table->float('torax');
            $table->float('braco_direito');
            $table->float('braco_esquerdo');
            $table->float('cintura');
            $table->float('antebraco_direito');
            $table->float('antebraco_esquerdo');
            $table->float('abdomen');
            $table->float('coxa_direita');
            $table->float('coxa_esquerda');
            $table->float('quadril');
            $table->float('panturrilha_direita');
            $table->float('panturrilha_esquerda');
            $table->float('punho');
            $table->float('biceps_femoral_direito');
            $table->float('biceps_femoral_esquerdo');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('avaliations');
    }
}
