<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SeederCoordenador extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coordenador = new User;
        $coordenador->nome_user = "Coordenador excluído do sistema";
        $coordenador->email_user = "null@email.com";
        $coordenador->dataN_user = date("Y-m-d");
        $coordenador->tipo_user = "COORDENADOR";
        $coordenador->tel_user = "(00) 0.0000-0000";
        $coordenador->password = "null";
        $coordenador->escola_id = 1;
        $coordenador->save();
    }
}
