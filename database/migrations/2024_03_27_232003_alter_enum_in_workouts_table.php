<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::table('workouts', function (Blueprint $table) {
            $table->string('day_without_accents')->after('day')->nullable();
        });


        $daysMapping = [
            'TERÇA' => 'TERCA',
            'SÁBADO' => 'SABADO'
        ];
        foreach ($daysMapping as $original => $new) {
            DB::table('workouts')->where('day', $original)->update(['day_without_accents' => $new]);
        }


        Schema::table('workouts', function (Blueprint $table) {
            $table->dropColumn('day');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->renameColumn('day_without_accents', 'day');
        });
    }


    public function down()
    {
        //
    }
};
