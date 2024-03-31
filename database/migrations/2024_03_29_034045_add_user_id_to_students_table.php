<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Adiciona a coluna user_id
            $table->bigInteger('user_id')->unsigned()->nullable();
            
            // Define a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['user_id']);
            
            // Remove a coluna user_id
            $table->dropColumn('user_id');
        });
    }
}
