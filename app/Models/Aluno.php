<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    public function ocorrencias() {
        return $this->belongsTo('App\Models\Ocorrencia');
    }

    public function cursos() {
        return $this->belongsTo('App\Models\Curso');
    }

    public function escola() {
        return $this->belongsTo('App\Models\Escola');
    }

    public function turma() {
        return $this->belongsTo('App\Models\Turma');
    }
}
