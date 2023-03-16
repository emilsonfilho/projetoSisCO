<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Error;
use Illuminate\Http\Request;

class ControllerCursos extends Controller
{
    public function index()
    {
        return view('content.cadastro-curso');
    }

    public function store(Request $request)
    {
        $curso = new Curso;

        $curso->nome_curso = preg_replace('/\s+$/u', '', mb_strtoupper($request->curso, 'UTF-8'));

        $cursos = Curso::all();
        foreach ($cursos as $cursoBanco) {
            if ($cursoBanco->nome_curso !== $curso->nome_curso) {
                $curso->save();

                return redirect('/cadTurmas')->with('msg', 'Curso cadastrado com sucesso.');
            } else {
                // throw new Error('');
                return redirect('/cadCurso')->with('err', 'Curso já cadastrado no banco de dados');
            }
        }
    }
}
