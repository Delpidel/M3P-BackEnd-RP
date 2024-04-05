<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\App;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (App::environment('testing')) {

            Student::create(['name' => 'Alice']);
            Student::create(['name' => 'Bob']);
            Student::create(['name' => 'Charlie']);

        }
    }
}
