<?php

namespace Database\Seeders;

use App\Models\Escola;
use Illuminate\Database\Seeder;

class SeederEscola extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escola = new Escola;
        $escola->inep = 23323612;
        $escola->nome_escola = "EEEP José Maria Falcão";
        $escola->email_escola = "josemariafalcao@escola.ce.gov.br";
        $escola->endereco_escola = "Rua Raimundo Correia Lima, sn, Pacajus - CE, 62870-000";
        $escola->tel_escola = "(85) 3348-1599";
        $escola->crede = 9;
        $escola->save();
    }
}
