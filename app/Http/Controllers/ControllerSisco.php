<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControllerSisco extends Controller
{
    public function index()
    {
        $alunosAtuais = DB::table('tb_jmf_discente')
        ->join('tb_jmf_turma', 'tb_jmf_discente.discente_idTurma', '=', 'tb_jmf_turma.turma_id')
        ->where('tb_jmf_turma.turma_ano', '>=', (date("Y") - 2))
        ->orderBy('tb_jmf_discente.discente_nome', 'asc')
        ->select('tb_jmf_discente.*')
        ->get();
        
        $alunosComOcorrencia = $alunosAtuais->filter(function ($aluno) {
            return DB::table('tb_sisco_ocorrencia')
                ->where('ocorrencia_idDiscente', $aluno->discente_matricula)
                ->exists();
        });

        if ($alunosComOcorrencia->isNotEmpty()) {
            $temOcorrencia = true;
        } else {
            $temOcorrencia = false;
        }

        $nomeCurso = function ($param) {
            try {
                $curso = DB::table('tb_jmf_curso')->where('curso_id', $param->turma_idCurso)->first();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new Error('Curso não encontrado');
            }

            $nomeCurso = $curso->curso_nome;
            return $nomeCurso;
        };

        $numeroOcorrencias = function ($param) {
            return DB::table('tb_sisco_ocorrencia')
                ->join('tb_jmf_discente', 'tb_sisco_ocorrencia.ocorrencia_idDiscente', '=', 'tb_jmf_discente.discente_matricula')
                ->where('tb_jmf_discente.discente_idTurma', $param->turma_id)
                ->count();
        };

        $numeroAlertas = function ($param) {
            return DB::table('tb_sisco_evento')
                ->join('tb_jmf_discente', 'tb_sisco_evento.evento_idDiscente', '=', 'tb_jmf_discente.discente_matricula')
                ->where('tb_jmf_discente.discente_idTurma', $param->turma_id)
                ->count();
        };

        $alertas = collect(['alerta1', 'alerta2', 'alerta3']);


        $pegaNomeAluno = function ($matricula) {
            try {
                $aluno = DB::table('tb_jmf_discente')->where('discente_matricula', $matricula)->first();
                return $aluno->nome_aluno;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new Error('Aluno não encontrado no banco de dados');
            }
        };

        $pegaMotivosAlerta = function ($alerta) {
            return ['Motivo 1', 'Motivo 2', 'Motivo 3'];
        };

        $objAluno = function ($matricula) {
            try {
                $aluno = DB::table('tb_jmf_discente')->where('discente_matricula', $matricula)->first();
                return $aluno;
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new Error('Aluno não encontrado no banco de dados.');
            }
        };

        $getTurma = function ($id) {
            $turma = DB::table('tb_jmf_turma')->where('turma_id', $id)->first();
            $turma = ((date("Y") - $turma->turma_ano) + 1) . "º Ano - " . $turma->turma_nome;
        
            if (!$turma) {
                throw new Error('Turma não encontrada');
            }
        
            return $turma;
        };
        

        $pegaTipoUser = function ($id) {
            return DB::table('tb_jmf_usuario')->select('usuario_perfil')->where('usuario_id', $id)->first()->usuario_perfil;
        };

        $getCursoNome = function ($idTurma) {
            $idCurso = DB::table('tb_jmf_turma')->select('turma_idCurso')->where('turma_id', $idTurma)->first()->turma_idCurso;
            $nomeCurso = DB::table('tb_jmf_curso')->select('curso_nome')->where('curso_id', $idCurso)->first()->curso_nome;
            return $nomeCurso;
        };

        $getAno = function ($id) {
            return DB::table('tb_jmf_turma')->select('turma_ano')->where('turma_id', $id)->first()->turma_ano;
        };


        $motivosOcorrencias = function () {
            return DB::table('tb_sisco_ocorrenciamotivo')->get();
        };

        return view('content.principal', [
            'alunos' => $alunosAtuais,
            'turmas' => DB::table('tb_jmf_turma')->get(),
            'nomeCurso' => $nomeCurso,
            'numeroOcorrencias' => $numeroOcorrencias,
            'temOcorrencia' => $temOcorrencia,
            'numeroAlertas' => $numeroAlertas,
            'alertas' => $alertas,
            'pegaNomeAluno' => $pegaNomeAluno,
            'pegaMotivosAlerta' => $pegaMotivosAlerta,
            'objAluno' => $objAluno,
            'getTurma' => $getTurma,
            'tipoUser' => $pegaTipoUser(auth()->id()),
            'getCursoNome' => $getCursoNome,
            'getAno' => $getAno,
            'motivosOcorrencias' => $motivosOcorrencias(),
        ]);
    }

    public function store(Request $request)
    {
        $aluno = DB::table('tb_jmf_discente')->where('discente_nome', $request->nomeAluno)->first();
        $responsavelLegal = DB::table('tb_jmf_responsavellegal')->where('responsavelLegal_id', $aluno->discente_idResponsavel)->first();
        $categoria = DB::table('tb_sisco_ocorrenciamotivo')->where('ocorrenciaMotivo_id', $request->motivo)->first();

        DB::table('tb_sisco_ocorrencia')->insert([
            'ocorrencia_idDiscente' => $aluno->discente_matricula,
            'ocorrencia_idColaborador' => 16849219,
            'ocorrencia_idResponsavelLegal' => $responsavelLegal->responsavelLegal_id,
            'ocorrencia_idCategoria' => $categoria->ocorrenciaMotivo_idCategoria,
            'ocorrencia_idMotivo' => $request->motivo,
            'ocorrencia_data' => $request->data,
            'ocorrencia_hora' => $request->hora,
            'ocorrencia_descricao' => $request->obs,
            'ocorrencia_dataTime' => Carbon::now(),
        ]);

        if ($categoria->ocorrenciaMotivo_idCategoria === 1) {
            return redirect('/principal')->with('msg', 'Ocorrência adicionada. Passível de um dia de suspensão e retorno à escola com pais ou responsáveis');
        } else {
            return redirect('/principal')->with('msg', 'Ocorrência adicionada. Passível de três dias de suspensão e retorno à escola com pais ou responsáveis');
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/paginaLogin');
    }

    public function editOcorrencia($id) {
        $ocorrencia = DB::table('tb_sisco_ocorrencia')->where('ocorrencia_id', $id)->first();
        $alunoDaOcorrencia = DB::table('tb_jmf_discente')->where('discente_matricula', $ocorrencia->ocorrencia_idDiscente)->first();

        $getCursoNome = function ($idTurma) {
            $idCurso = DB::table('tb_jmf_turma')->select('turma_idCurso')->where('turma_id', $idTurma)->first()->turma_idCurso;
            $nomeCurso = DB::table('tb_jmf_curso')->select('curso_nome')->where('curso_id', $idCurso)->first()->curso_nome;
            return $nomeCurso;
        };

        $getTurma = function ($id) {
            $turma = DB::table('tb_jmf_turma')->where('turma_id', $id)->first();
            $turma = ((date("Y") - $turma->turma_ano) + 1) . "º Ano - " . $turma->turma_nome;
        
            if (!$turma) {
                throw new Error('Turma não encontrada');
            }
        
            return $turma;
        };

        $motivosOcorrencias = function () {
            return DB::table('tb_sisco_ocorrenciamotivo')->get();
        };

        return view('content.editOcorrencia', [
            'ocorrencia' => $ocorrencia,
            'discente' => $alunoDaOcorrencia,
            'alunos' => DB::table('tb_jmf_discente')->get(),
            'getCursoNome' => $getCursoNome,
            'getTurma' => $getTurma,
            'motivosOcorrencias' => $motivosOcorrencias()
        ]);
    }

    public function edit(Request $request, $id) {
        $aluno = DB::table('tb_jmf_discente')->where('discente_nome', $request->nomeAluno)->first();
        $categoria = DB::table('tb_sisco_ocorrenciamotivo')->where('ocorrenciaMotivo_id', $request->motivo)->first();
        
        DB::table('tb_sisco_ocorrencia')->where('ocorrencia_id', $id)->update([
            'ocorrencia_idCategoria' => $categoria->ocorrenciaMotivo_idCategoria,
            'ocorrencia_idMotivo' => $request->motivo,
            'ocorrencia_data' => $request->data,
            'ocorrencia_hora' => $request->hora,
            'ocorrencia_descricao' => $request->obs,
            'ocorrencia_dataTime' => Carbon::now(),
        ]);

        return redirect('/principal')->with(['msg' => 'Ocorrência editada com sucesso']);
    }
}
