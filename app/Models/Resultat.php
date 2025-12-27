<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semestre',
        'matiere1','note1',
        'matiere2','note2',
        'matiere3','note3',
        'matiere4','note4',
        'matiere5','note5',
        'moyenne',
        'decision',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
