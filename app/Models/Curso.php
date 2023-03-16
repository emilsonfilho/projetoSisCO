<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public function aluno() {
        return $this->hasMany('App\Models\Aluno');
    }

    public function escola() {
        return $this->belongsTo('App\Models\Escola');
    }

    public function turma() {
        return $this->hasMany('App\Models\Turma');
    }
}
