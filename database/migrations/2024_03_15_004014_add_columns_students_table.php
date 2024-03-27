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

        Schema::table('students', function (Blueprint $table) {

            $table->string('email', 255)->unique();
            $table->date('date_birth')->required();
            $table->string('contact', 20);
            $table->string('cpf')->unique();
            $table->string('cep', 20)->required();
            $table->string('city', 50)->required();
            $table->string('neighborhood', 50)->required();
            $table->string('number', 30)->required();
            $table->string('street', 30)->required();
            $table->string('state', 2)->required();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('date_birth');
            $table->dropColumn('contact');
            $table->dropColumn('cpf');
            $table->dropColumn('city');
            $table->dropColumn('neighborhood');
            $table->dropColumn('number');
            $table->dropColumn('street');
            $table->dropColumn('state');
            $table->dropColumn('cep');
        });
    }
};