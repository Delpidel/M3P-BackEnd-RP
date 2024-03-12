<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meal_plans', function (Blueprint $table) {

                $table->id();
                $table->dateTime('date');
                $table->float('weight');
                $table->float('height');
                $table->integer('age');

                $table->text('observations_to_student')->nullable();
                $table->text('observations_to_nutritionist')->nullable();

                $table->unsignedBigInteger('front')->nullable();
                $table->foreign('front')->references('id')->on('files');

                $table->unsignedBigInteger('back')->nullable();
                $table->foreign('back')->references('id')->on('files');

                $table->unsignedBigInteger('right')->nullable();
                $table->foreign('right')->references('id')->on('files');

                $table->unsignedBigInteger('left')->nullable();
                $table->foreign('left')->references('id')->on('files');

                $table->float('torax');
                $table->float('braco_esquerdo');
                $table->float('braco_direito');
                $table->float('cintura');
                $table->float('antebraco_esquerdo');
                $table->float('abdome');
                $table->float('coxa_direita');
                $table->float('coxa_esquerda');
                $table->float('quadril');
                $table->float('panturrilha_direita');
                $table->float('panturilha_esquerda');
                $table->float('punho');
                $table->float('b_femural');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
