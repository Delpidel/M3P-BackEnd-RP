<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'date', 'weight', 'height', 'age', 'observations_to_student', 'observations_to_nutritionist', 'back', 'front', 'left', 'right', 'torax', 'braco_direito', 'braco_esquerdo', 'cintura', 'antebraco_direito', 'antebraco_esquerdo', 'abdomen', 'coxa_direita', 'coxa_esquerda', 'quadril', 'panturrilha_direita', 'panturrilha_esquerda', 'punho', 'biceps_femoral_direito', 'biceps_femoral_esquerdo'];


    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function file() {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function imagemFront() {
        return $this->hasOne(File::class, "id","front");
    }

    public function imagemBack() {
        return $this->hasOne(File::class, "id","back");
    }

    public function imagemLeft() {
        return $this->hasOne(File::class, "id","left");
    }

    public function imagemRight() {
        return $this->hasOne(File::class, "id","right");
    }
}
