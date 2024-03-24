<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id'];

    protected $hidden = [
        'user_id',
        'updated_at',
        'created_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
