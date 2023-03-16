<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    public function aluno() {
        return $this->hasMany('App\Models\Aluno');
    }

    public function curso() {
        return $this->belongsTo('App\Models\Curso');
    }

    public function escola() {
        return $this->belongsTo('App\Models\Escola');
    }
}
