<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Escola;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerProfessores extends Controller
{

    public function index()
    {
        // $corpoDocente = User::orderBy('nome_user', 'asc')->get();
        $colaboradores = DB::table('tb_jmf_colaborador')->orderBy('colaborador_nome', 'asc')->get();
        $colaboradores = DB::table('tb_jmf_colaborador')
            ->orderByRaw("CASE
                WHEN colaborador_idSetor = 3 THEN 1
                WHEN colaborador_idSetor = 2 THEN 2
                WHEN colaborador_idSetor = 1 THEN 3
                WHEN colaborador_idSetor = 4 THEN 4
                ELSE 5
                END")
            ->orderBy('colaborador_nome', 'asc')
            ->get();

        $getSetor = function ($colaborador) {
            // Olha... eu estou pegando o setor, mas o recomendavel e'que na tabela de Colaborador tivesse o código da Função e não do Setor, pois o setor não tem uma chave estrangeira
            $idSetor = $colaborador->colaborador_idSetor;
            $nomeSetor = DB::table('tb_jmf_setor')->select('setor_nome')->where('setor_id', $idSetor)->first()->setor_nome;

            // $usuarios = DB::table('tb_jmf_colaborador')
            //     ->join('tb_jmf_setor', 'tb_jmf_colaborador.colaborador_idSetor', '=', 'tb_jmf_setor.setor_id')
            //     ->join('tb_jmf_funcao', 'setor.funcao_id', '=', 'funcao.id')
            //     ->select('tb_jmf_colaborador.*', 'funcao.nome as nome_funcao')
            //     ->get();

            return $nomeSetor;
        };

        return view('content.dashboard-professores', [
            'colaboradores' => $colaboradores,
            'tipoUser' => auth()->user()->tipo_user,
            'getSetor' => $getSetor
        ]);
    }
}
