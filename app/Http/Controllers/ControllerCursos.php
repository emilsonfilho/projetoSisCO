<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class ControllerCursos extends Controller
{
    public function index()
    {
        $tipoUser = auth()->user()->tipo_user;
        return view('content.cadastro-curso', compact('tipoUser'));
    }

    public function store(Request $request)
    {
        $curso = new Curso;

        $curso->nome_curso = preg_replace('/\s+$/u', '', mb_strtoupper($request->curso, 'UTF-8'));

        $cursoBanco = Curso::where('nome_curso', $curso->nome_curso)->first();
        if ($cursoBanco) {
            return redirect('/cadCurso')->with('err', 'Curso já cadastrado no banco de dados');
        }
        $curso->save();

        return redirect('/cadTurmas')->with('msg', 'Curso cadastrado com sucesso.');
    }
}
