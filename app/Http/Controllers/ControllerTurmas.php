<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Curso;
use App\Models\Aluno;
use App\Models\Ocorrencia;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Date;

class ControllerTurmas extends Controller
{
    public function index()
    {
        $turmas = Turma::all();

        $nomeCurso = function ($param) {
            try {
                $curso = Curso::where('id', $param->cursos_id)->first();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            }
            $nomeCurso = $curso->nome_curso;
            return $nomeCurso;
        };

        return view('content.opcoesturmas', ['turmas' => $turmas, 'nomeCurso' => $nomeCurso]);
    }

    public function register()
    {
        $cursos = Curso::all();

        return view('content.cadastro-turmas', ['cursos' => $cursos]);
    }

    public function store(Request $request)
    {
        $turma = new Turma;

        $turma->ano = $request->ano;
        $turma->cursos_id = $request->curso;

        $turmasBanco = Turma::all();
        foreach ($turmasBanco as $turmaBanco) {
            if (($turmaBanco->ano == $turma->ano) && ($turmaBanco->cursos_id == $turma->cursos_id)) {
                return redirect('/cadTurmas')->with('err', 'Turma já registrada.');        
            }
       }
        $turma->save();

        return redirect('/cadTurmas')->with('msg', 'Turma registrada com sucesso.');
    }

    public function relatorioIndex($id)
    {
        $turma = Turma::findOrFail($id);

        $nomeCurso = function ($param) {
            // Frequentemente falta o first, só ter mais uma olhadinha
            $curso = Curso::where('id', $param->cursos_id)->first();
            $nomeCurso = $curso->nome_curso;
            return $nomeCurso;
        };

        // Retorna array com todos os alunos da turma
        $getAlunosTurma = function ($turma) {
            $alunosTurma = Aluno::where('turmas_id', $turma->id)->orderBy('nome_aluno')->get();
            return $alunosTurma;
        };

        $numeroOcorrencias = function ($turma, $getAlunosTurmas) {
            $quantidadeOcorrencias = 0;
            $alunos = $getAlunosTurmas($turma);
            foreach ($alunos as $aluno) {
                $quantidadeOcorrencias = $quantidadeOcorrencias + $aluno->qntd_ocorrencias_assinadas;
            }
            return $quantidadeOcorrencias;
        };

        // Recebe $turma
        $curso = $nomeCurso($turma);
        $serie = (date("Y") - $turma->ano) + 1;

        $numOcorrenciasTurma = $numeroOcorrencias($turma, $getAlunosTurma);

        return view('relatorios.relatorio-turmas', [
            'nomeTurma' => $serie . "º Ano - " . $curso,
            'numOcorrenciasTurma' => $numOcorrenciasTurma,
            'alunos' => $getAlunosTurma($turma)
        ]);
    }

    public function search($id)
    {
        $aluno = Aluno::findOrFail($id);

        $getNomeCurso = function ($id_curso) {
            return Curso::findOrFail($id_curso)->nome_curso;
        };

        $getSerieTurma = function ($id_turma) {
            $ano = Turma::findOrFail($id_turma)->ano;
            return (date("Y") - $ano) + 1;
        };

        $formatDataN = function ($data) {
            // return strtotime($data);
            $f = implode('/', array_reverse(explode('-', $data)));
            return $f;
        };

        $formatTime = function ($hora) {
            return date("H:i", strtotime($hora));
        };

        $ocorrencias = Ocorrencia::where('alunos_id', $aluno->id)->get();

        $getCoordenador = function ($id) {
            $coordenador_id = Ocorrencia::findOrFail($id)->users_id;
            $coordenador_nome = User::findOrFail($coordenador_id)->nome_user;
            return $coordenador_nome;
        };

        return view('relatorios.relatorio-aluno-individual', [
            'id' => $aluno->id,
            'nome' => $aluno->nome_aluno,
            'turma' => $getSerieTurma($aluno->turmas_id) . "º Ano - " . $getNomeCurso($aluno->cursos_id),
            'serie' => $getSerieTurma($aluno->turmas_id) . "º Ano",
            'curso' => $getNomeCurso($aluno->cursos_id),
            'email' => $aluno->email_aluno,
            'matricula' => $aluno->matricula,
            'dataN' => $formatDataN($aluno->dataN_aluno),
            'nomeResponsavel' => $aluno->nome_responsavel,
            'endereco' => $aluno->end_responsavel,
            'telefone' => $aluno->tel_responsavel,
            'ocorrencias' => $ocorrencias,
            'getCoordenador' => $getCoordenador,
            'formatarData' => $formatDataN,
            'formatarHora' => $formatTime
        ]);
    }
}
