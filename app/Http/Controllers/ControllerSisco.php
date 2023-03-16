<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Escola;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Curso;
use App\Models\Alerta;
use Error;

class ControllerSisco extends Controller
{
    public function index()
    {
        $alunos = Aluno::all();
        $turmas = Turma::all();
        $alunosAtuais = [];

        foreach ($alunos as $aluno) {
            $idAlunoTurma = $aluno->turmas_id;
            try {
                $turmaAluno = Turma::findOrFail($idAlunoTurma);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { //oo//
            }

            if ($turmaAluno->ano >= (date("Y") - 2)) {
                $alunosAtuais[] = $aluno;
            }
        }

        $hasOcorrencia = function ($alunos, $temOcorrencia) {
            foreach ($alunos as $aluno) {
                if ($aluno->qntd_ocorrencias_assinadas != 0) {
                    return true;
                }
            }
            return false;
        };

        $nomeCurso = function ($param) {
            try {
                $curso = Curso::findOrFail($param->cursos_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            }

            $nomeCurso = $curso->nome_curso;
            return $nomeCurso;
        };

        $numeroOcorrencias = function ($param) {
            $todosAlunos = Aluno::all();
            $quantidadeOcorrencias = 0;
            for ($i = 0; $i < count($todosAlunos); $i++) {
                if ($todosAlunos[$i]->turmas_id == $param->id) {
                    // EXPLICANDO: Temos a soma dos números de todas as ocorrências de todos os estudantes
                    $quantidadeOcorrencias = $quantidadeOcorrencias + $todosAlunos[$i]->qntd_ocorrencias_assinadas;
                }
            }
            return $quantidadeOcorrencias;
        };

        $numeroAlertas = function ($turma) {
            $todosAlunos = Aluno::all();
            $quantidadeAlertas = 0;
            foreach ($todosAlunos as $aluno) {
                if ($aluno->turmas_id == $turma->id) {
                    $quantidadeAlertas = $quantidadeAlertas + $aluno->qntd_alertas;
                }
            }
            return $quantidadeAlertas;
        };

        $alertas = Alerta::where('concluido', false)->get();

        $pegaNomeAluno = function ($id) {
            try {
                $aluno = Aluno::findOrFail($id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            } // Pega o obj do determinado aluno
            return $aluno->nome_aluno;
        };

        $pegaMotivosAlerta = function ($alerta) {
            $motivos = [];
            $arrayIds = $alerta->motivos_alerta;
            foreach ($arrayIds as $motivo) {
                // $ocorrencia = Ocorrencia::where('id', $motivo)->first(); // faz o filtro por id
                $ocorrencia = Ocorrencia::findOrFail($motivo);
                $motivos[] = $ocorrencia->observacao;
            }
            return $motivos;
        };

        $objAluno = function($id) {
            try {
                $aluno = Aluno::findOrFail($id);
                return $aluno;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new Error('Aluno não encontrado no banco de dados.');
            }
        };

        $getTurma = function($id) {
            $turma = Turma::findOrFail($id);
            $serie = (date("Y") - $turma->ano) + 1;
            $curso = Curso::findOrFail($turma->cursos_id)->nome_curso;
            $turma = $serie . "º Ano - " . $curso;
            return $turma;
        };

        $temOcorrencia = $hasOcorrencia($alunos, $this);
        return view('content.principal', [
            'alunos' => $alunosAtuais,
            'turmas' => $turmas,
            'nomeCurso' => $nomeCurso,
            'numeroOcorrencias' => $numeroOcorrencias,
            'temOcorrencia' => $temOcorrencia,
            'numeroAlertas' => $numeroAlertas,
            'alertas' => $alertas,
            'pegaNomeAluno' => $pegaNomeAluno,
            'pegaMotivosAlerta' => $pegaMotivosAlerta,
            'objAluno' => $objAluno,
            'getTurma' => $getTurma
        ]);
    }

    public function store(Request $request)
    {
        $ocorrencia = new Ocorrencia;

        $aluno = Aluno::where('nome_aluno', $request->nome)->first(); // Recebe aluno que tem a ocorrencia a ser colocada
        $escola = Escola::findOrFail(1);
        $user = auth()->id(); 

        $ocorrencia->motivo = $request->motivo;
        $ocorrencia->observacao = $request->obs;
        $ocorrencia->data = $request->data;
        $ocorrencia->hora = $request->hora;
        $ocorrencia->alunos_id = $aluno->id;
        $ocorrencia->escola_id = $escola->id;
        $ocorrencia->users_id = $user;
        $ocorrencia->save();

        $aluno->qntd_ocorrencias_assinadas += 1;
        if ($aluno->qntd_ocorrencias_assinadas % 3 == 0) {
            $alerta = new Alerta;

            $idsOcorrencias = [];

            $ocorrencias = Ocorrencia::all();
            foreach ($ocorrencias as $ocorrencia) {
                if ($ocorrencia->alunos_id == $aluno->id) {
                    $idsOcorrencias[] = $ocorrencia->id;
                }
            }

            $idsUltimasOcorrencias = [];

            for ($i = 3; $i > 0; $i--) {
                $idsUltimasOcorrencias[] = $idsOcorrencias[count($idsOcorrencias) - $i];
            }
            // Agora temos os três ids dos motivos na array de $idsOcorrencias, temos que colocar ela no banco

            $alerta->motivos_alerta = $idsUltimasOcorrencias; // Olhe as anotações porque você tem que permitir que seu banco aceite arrays
            $alerta->concluido = false;
            $alerta->aluno_id = $aluno->id;
            $alerta->save();

            $aluno->qntd_alertas += 1;
        }

        $aluno->save();
        
        return redirect('/principal')->with('msg', 'Ocorrência adicionada com sucesso.');
    }

    public function marked($id) {
        try {
            $alerta = Alerta::findOrFail($id);
            $alerta->concluido = true;
            $alerta->save();
            return redirect('/principal');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Error('Alerta não encontrado no banco de dados');
        }
    }
}
