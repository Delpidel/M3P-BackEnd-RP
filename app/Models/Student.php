<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function mealPlanSchedules()
    {
        return $this->hasMany(MealPlanSchedule::class, 'student_id');
    }
}
