<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\ObjectType;
use stdClass;

class ControllerTurmas extends Controller
{
    public function index()
    {
        $anoAtual = date('Y');
        $anoMinimo = $anoAtual - 2;
        // $turmas = Turma::where('ano', '>=', $anoMinimo)->where('ano', '<=', $anoAtual)->orderBy('ano')->orderBy('curso.nome_curso')->get();
        // $turmas = Turma::whereBetween('ano', [date("Y"), date("Y") - 2])->orderBy('cursos_id')->get();
        // $ano_atual = intval(date('Y'));
        // $turmas = Turma::where('ano', '>=', $ano_atual - 2)
        //     ->where('ano', '<=', $ano_atual)
        //     ->orderBy('cursos_id')
        //     ->get();
        // $turmas = Turma::with('curso')
        //         ->join('cursos', 'turmas.cursos_id', '=', 'cursos.id')
        //         ->select('turmas.id AS turma_id', 'turmas.ano', 'cursos.nome_curso', 'cursos.id AS curso_id')
        //         ->where('ano', '>=', $anoMinimo)
        //         ->where('ano', '<=', $anoAtual)
        //         ->orderBy('ano', 'desc')
        //         ->orderBy('cursos_id', 'asc')
        //         ->get();

        $turmas = DB::table('tb_jmf_turma')
            ->join('tb_jmf_curso', 'tb_jmf_turma.turma_idCurso', '=', 'tb_jmf_curso.curso_id')
            ->select('tb_jmf_turma.turma_id AS turma_id', 'tb_jmf_turma.turma_ano', 'tb_jmf_curso.curso_nome', 'tb_jmf_curso.curso_id AS curso_id')
            ->where('tb_jmf_turma.turma_ano', '>=', $anoMinimo)
            ->where('tb_jmf_turma.turma_ano', '<=', $anoAtual)
            ->orderBy('tb_jmf_turma.turma_ano', 'desc')
            ->orderBy('tb_jmf_turma.turma_idCurso', 'asc')
            ->get();

        $pegaTipoUser = function ($id) {
            // return User::findOrFail($id)->tipo_user;
            return DB::table('tb_jmf_usuario')->select('usuario_perfil')->where('usuario_id', $id)->first()->usuario_perfil;
        };

        $nomeCurso = function ($param) {
            try {
                $curso = DB::table('tb_jmf_curso')->where('id', $param->cursos_id)->first();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return null;
            }
            $nomeCurso = $curso->nome_curso;
            return $nomeCurso;
        };

        return view('content.opcoesturmas', ['turmas' => $turmas, 'nomeCurso' => $nomeCurso,  'tipoUser' => $pegaTipoUser(auth()->id())]);
    }

    public function relatorioIndex($id)
    {
        // $turma = Turma::findOrFail($id);
        $turma = DB::table('tb_jmf_turma')->where('turma_id', $id)->first();

        $nomeCurso = function ($param) {
            return DB::table('tb_jmf_curso')->select('curso_nome')->where('curso_id', $param->turma_idCurso)->first()->curso_nome;
        };

        $getAlunosTurma = function ($turma) {
            return DB::table('tb_jmf_discente')->where('discente_idTurma', $turma->turma_id)->orderBy('discente_nome', 'asc')->get();
        };
        // $getAlunosTurma(DB::table('tb_jmf_turma')->where('turma_id', 1)->first());

        $getQuantidadeOcorrencias = function ($id) {
            // return $alunos->sum('qntd_ocorrencias_assinadas');
            return DB::table('tb_sisco_ocorrencia')
                ->join('tb_jmf_discente', 'tb_sisco_ocorrencia.ocorrencia_idDiscente', '=', 'tb_jmf_discente.discente_matricula')
                ->where('tb_jmf_discente.discente_idTurma', $id)
                ->count();


        };

        $getQuantidadeAlertas = function ($id) {
            // return $alunos->sum('qntd_alertas');

            return DB::table('tb_sisco_evento')
                ->join('tb_jmf_discente', 'tb_sisco_evento.evento_idDiscente', '=', 'tb_jmf_discente.discente_matricula')
                ->where('tb_jmf_discente.discente_idTurma', $id)
                ->count();
        };

        $curso = $nomeCurso($turma);
        $serie = (date("Y") - $turma->turma_ano) + 1;

        $pegaTipoUser = function ($id) {
            // return User::findOrFail($id)->tipo_user;
            return DB::table('tb_jmf_usuario')->select('usuario_perfil')->where('usuario_id', $id)->first()->usuario_perfil;
        };

        $numOcorrenciasTurma = $getQuantidadeOcorrencias($id);

        $numAlertasTurma = $getQuantidadeAlertas($id);

        $numOcorrenciasAluno = function ($id) {
            return DB::table('tb_sisco_ocorrencia')->where('ocorrencia_idDiscente', $id)->count();
        };

        $numEventosAluno = function ($id) {
            return DB::table('tb_sisco_evento')->where('evento_idDiscente', $id)->count();
        };


        return view('relatorios.relatorio-turmas', [
            'nomeTurma' => $serie . "º Ano - " . $curso,
            'numOcorrenciasTurma' => $numOcorrenciasTurma,
            'numAlertasTurmas' => $numAlertasTurma,
            'alunos' => $getAlunosTurma($turma),
            'numOcorrenciasAluno' => $numOcorrenciasAluno,
            'numEventosAluno' => $numEventosAluno,
            'tipoUser' => $pegaTipoUser(auth()->id())
        ]);
    }

    public function search($matricula)
    {
        $aluno = DB::table('tb_jmf_discente')->where('discente_matricula', $matricula)->first();
        $responsavel = DB::table('tb_jmf_responsavellegal')->where('responsavelLegal_id', $aluno->discente_idResponsavel)->first();

        // Recebe o id da turma e de lá pega o id do curso
        $getNomeCurso = function ($id_turma) {
            $id_curso = DB::table('tb_jmf_turma')->select('turma_idCurso')->where('turma_id', $id_turma)->first()->turma_idCurso;
            return DB::table('tb_jmf_curso')->select('curso_nome')->where('curso_id', $id_curso)->first()->curso_nome;
        };

        $getSerieTurma = function ($id_turma) {
            $ano = DB::table('tb_jmf_turma')->select('turma_ano')->where('turma_id', $id_turma)->first()->turma_ano;
            return (date("Y") - $ano) + 1;
        };

        $formatDataN = function ($data) {
            $f = implode('/', array_reverse(explode('-', $data)));
            return $f;
        };

        $formatTime = function ($hora) {
            return date("H:i", strtotime($hora));
        };

        $ocorrencias = DB::table('tb_sisco_ocorrencia')->where('ocorrencia_idDiscente', $aluno->discente_matricula)->get();

        $getCoordenador = function ($id) {
            // $coordenador_id = Ocorrencia::findOrFail($id)->users_id;
            $colaborador_matricula = 16849219;
            // LEMBRAR DE MUDAR PARA UM NÚMERO DINÂMICO 
            // $coordenador_nome = User::findOrFail($colaborador_matricula)->nome_user;
            $coordenador_nome = DB::table('tb_jmf_colaborador')->select('colaborador_nome')->where('colaborador_matricula', $colaborador_matricula)->first()->colaborador_nome;
            return $coordenador_nome;
        };

        $pegaNumSetor = function ($id) {
            // return User::findOrFail($id)->tipo_user;
            return DB::table('tb_jmf_colaborador')->select('colaborador_idSetor')->where('colaborador_matricula', $id)->first()->colaborador_idSetor;
        };

        $getMotivoOcorrencia = function ($id) {
            $idMotivo = DB::table('tb_sisco_ocorrencia')->where('ocorrencia_id', $id)->first()->ocorrencia_idMotivo;
            return DB::table('tb_sisco_ocorrenciamotivo')->where('ocorrenciaMotivo_id', $idMotivo)->first()->ocorrenciaMotivo_descricao;
        };

        return view('relatorios.relatorio-aluno-individual', [
            'id' => $aluno->discente_matricula,
            'turma_id' => $aluno->discente_idTurma,
            'nome' => $aluno->discente_nome,
            'turma' => $getSerieTurma($aluno->discente_idTurma) . "º Ano - " . $getNomeCurso($aluno->discente_idTurma),
            'serie' => $getSerieTurma($aluno->discente_idTurma) . "º Ano",
            'curso' => $getNomeCurso($aluno->discente_idTurma),
            'email' => $aluno->discente_email,
            'matricula' => $aluno->discente_matricula,
            'dataN' => $formatDataN($aluno->discente_dataNascimento),
            'nomeResponsavel' => $responsavel->responsavelLegal_nome,
            'telefone' => $responsavel->responsavelLegal_telefone,
            'whatsapp' => $responsavel->responsavelLegal_whatsapp,
            'ocorrencias' => $ocorrencias, 
            'getCoordenador' => $getCoordenador,
            'formatarData' => $formatDataN,
            'formatarHora' => $formatTime,
            'tipoUser' => $pegaNumSetor(16849219),
            'getMotivoOcorrencia' => $getMotivoOcorrencia,
            // LEMBRE-SE QUE AQUI VAI TER QUE SER O USUÁRIO AUTENTICADO, OK?
        ]);
    }
}
