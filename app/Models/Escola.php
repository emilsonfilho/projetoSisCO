<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasMany('App\Models\User');
    }

    public function aluno() {
        return $this->hasMany('App\Models\Aluno');
    }

    public function curso() {
        return $this->hasMany('App\Models\Curso');
    }

    public function turma() {
        return $this->hasMany('App\Models\Turma');
    }
}
