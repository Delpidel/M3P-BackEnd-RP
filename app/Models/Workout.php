<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'exercise_id',
        'repetitions',
        'weight',
        'break_time',
        'day',
        'observations',
        'time'
    ];

    protected $hidden = [
        "updated_at",
        "created_at",
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
