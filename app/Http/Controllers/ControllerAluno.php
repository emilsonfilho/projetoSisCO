<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Alerta;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Curso;
use App\Models\Ocorrencia;
use DateTime;
use Error;
use Illuminate\Http\Request;


class ControllerAluno extends Controller
{
    public function index()
    {
        // $turmas = Turma::all();
        $anoAtual = date('Y');
        $anoMinimo = $anoAtual - 2;
        $turmas = Turma::where('ano', '>=', $anoMinimo)->where('ano', '<=', $anoAtual)->get();
        $pegaTipoUser = function ($id) {
            return User::findOrFail($id)->tipo_user;
        };


        $nomeCurso = function ($param) {
            try {
                $curso = Curso::findOrFail($param->cursos_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                throw new Error('Turma não encontrada');
            }
            $nomeCurso = $curso->nome_curso;
            return $nomeCurso;
        };

        return view('content.cadastro-alunos', [
            'turmas' => $turmas, 
            'nomeCurso' => $nomeCurso,
            'tipoUser' => $pegaTipoUser(auth()->id())
        ]);
    }

    public function store(Request $request)
    {
        $aluno = new Aluno;

        $pegaIdTurma = function ($param, $pegaIdCurso) {
            $arr = explode('º', $param);
            $serie = intval($arr[0]);
            $ano = 0; 

            switch ($serie) {
                case 1:
                    $ano = date("Y");
                    break;
                case 2:
                    $ano = (date("Y") - 1);
                    break;
                case 3:
                    $ano = (date("Y") - 2);
                    break;
            }

            $idCurso = $pegaIdCurso($param);
            $turmas = Turma::all();

            foreach ($turmas as $turma) {
                if (($turma->ano == $ano) && ($turma->cursos_id == $idCurso)) {
                    return $turma->id;
                }
            }
            throw new Error('Turma não encontrada.');
        };

        // Essa função consegue pegar o id do curso do cara
        $pegaIdCurso = function ($param) {
            $array = explode(' - ', $param);
            $nomeCurso = $array[1]; // CURSO
            return Curso::where('nome_curso', $nomeCurso)->first()->id;
        };

        $nome = mb_strtoupper($request->nome, 'UTF-8');

        $aluno->nome_aluno = $nome;
        $aluno->matricula = $request->matricula;
        $aluno->email_aluno = $request->email;
        $aluno->dataN_aluno = $request->dataN;
        $aluno->nome_responsavel = mb_strtoupper($request->nomeResponsavel, 'UTF-8');
        $aluno->end_responsavel = $request->end;
        $aluno->tel_responsavel = $request->telResponsavel;
        $aluno->qntd_ocorrencias_assinadas = 0;
        $aluno->qntd_alertas = 0;
        $aluno->escola_id = 1; // Novamente, esse sistema pega a JMF id = 1
        $aluno->turmas_id = $pegaIdTurma($request->turma, $pegaIdCurso);
        $aluno->cursos_id = $pegaIdCurso($request->turma);

        $aluno->save();

        return redirect('cadAlunos')->with('msg', 'Aluno cadastrado com sucesso.');
    }

    public function storeCSV(Request $request)
    {
        $arquivo = $_FILES['planilha'];
        // var_dump($arquivo);

        if ($arquivo['type'] == 'text/csv') {
            $dados_arquivo = fopen($arquivo['tmp_name'], "r");
            $pegaIdTurma = function ($ano, $curso, $pegaIdCurso) {
                $idCurso = $pegaIdCurso($curso);
                return Turma::where('ano', $ano)->where('cursos_id', $idCurso)->first()->id;
            };

            // Essa função consegue pegar o id do curso do cara
            $pegaIdCurso = function ($param) {

                $curso = Curso::where('nome_curso', $param)->first();

                return $curso->id;
            };


            while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {
                if ($linha[0] != "NOME") {


                    print_r($linha);
                    $aluno = new Aluno;
                    $aluno->nome_aluno = mb_strtoupper(mb_convert_encoding($linha[0], "UTF-8"), 'UTF-8');
                    $aluno->matricula = ($linha[1] ?? "");
                    $aluno->email_aluno = ($linha[2] ?? "");

                    $dataN = DateTime::createFromFormat('d/m/y', $linha[3]);

                    $aluno->dataN_aluno = $dataN->format('Y-m-d');
                    $aluno->nome_responsavel = mb_strtoupper(mb_convert_encoding($linha[6], "UTF-8"), 'UTF-8');
                    $aluno->end_responsavel = mb_convert_encoding($linha[7], "UTF-8");
                    $aluno->tel_responsavel = ($linha[8] ?? "");
                    $aluno->qntd_ocorrencias_assinadas = 0;
                    $aluno->qntd_alertas = 0;
                    $aluno->escola_id = 1; // Novamente, esse sistema pega a JMF id = 1
                    // $pegaIdTurma(ano_da_turma, nome_curso, funcao_pega_curso)
                    $aluno->turmas_id = $pegaIdTurma($linha[4], $linha[5], $pegaIdCurso);
                    $aluno->cursos_id = $pegaIdCurso($linha[5]);

                    $aluno->save();
                }
            }
            return redirect('/cadAlunos')->with('msg', 'Alunos cadastrado com sucesso.');
        } else {
            return redirect('/cadAlunos')->with('err', 'Selecione um arquivo csv!');
        }

        // return redirect('/cadAlunos');
    }

    public function destroy($id)
    {
        try {
            $aluno = Aluno::findOrFail($id);
            Alerta::where('aluno_id', $aluno->id)->delete();
            Ocorrencia::where('alunos_id', $aluno->id)->delete();
            $idTurmaAluno = Turma::findOrFail($aluno->turmas_id)->id;
            $aluno->delete();
            return redirect('/relturmas/' . $idTurmaAluno)->with('msg', 'Aluno removido com sucesso');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Error('Aluno não encontrado.');
        }
    }

    public function show($id)
    {
        try {
            $aluno = Aluno::findOrFail($id);
            $cursos = Curso::orderBy('nome_curso')->get();
            return view('content.editar-aluno', [
                'aluno' => $aluno,
                'cursos' => $cursos
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Error('Aluno não encontrado.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // $data = [
            //     'nome_aluno' => $request->nomeAluno,
            //     'matricula' => $request->matricula,
            //     'email_aluno' => $request->email,
            //     'dataN_aluno' => $request->dataN,
            //     'nome_responsavel' => $request->nomeResponsavel,
            //     'end_responsavel' => $request->endereco
            // ];
            $aluno = Aluno::findOrFail($id);

            // Essa função pega exatamente a turma do cara
            $pegaIdTurma = function ($param, $id_curso) {
                return Turma::where('ano', $param)->where('cursos_id', $id_curso)->first()->id;
            };

            $nome = mb_strtoupper($request->nomeAluno, 'UTF-8');

            $aluno->nome_aluno = $nome;
            $aluno->matricula = $request->matricula;
            $aluno->email_aluno = $request->email;
            $aluno->dataN_aluno = $request->dataN;
            $aluno->nome_responsavel = mb_strtoupper($request->nomeResponsavel, 'UTF-8');
            $aluno->end_responsavel = $request->end;
            $aluno->tel_responsavel = $request->telResponsavel;
            $aluno->qntd_ocorrencias_assinadas = $aluno->qntd_ocorrencias_assinadas;
            $aluno->qntd_alertas = $aluno->qntd_alertas;
            $aluno->escola_id = 1; // Novamente, esse sistema pega a JMF id = 1
            $id_curso = $request->curso;
            $aluno->turmas_id = $pegaIdTurma($request->serie, $id_curso);
            $aluno->cursos_id = $id_curso;

            $aluno->save();

            return redirect('/consulta/' . $aluno->id)->with('msg', 'Aluno editado com sucesso.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Error('Aluno não encontrado.');
        }
    }
}
