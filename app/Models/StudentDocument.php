<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $fillable = ['title', 'file'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
