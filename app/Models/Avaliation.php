<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'date', 'weight', 'height', 'age', 'observations_to_student', 'observations_to_nutritionist', 'file_id', 'measures'];

    public function Student() {
        return $this->hasOne(File::class, 'id', 'student_id');
    }

    public function file() {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
