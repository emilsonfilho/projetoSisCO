<?php

namespace Database\Seeders;

use App\Models\Escola;
use Illuminate\Database\Seeder;
use App\Models\User;

class SeederUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tel = Escola::findOrFail(1)->id;

        $adm = new User;
        $adm->nome_user = "SISCO ADM";
        $adm->email_user = "sisco@jmf";
        $adm->dataN_user = date("Y-m-d");
        $adm->tipo_user = "ADM";
        $adm->tel_user = $tel;
        $adm->password = "9ac8a9e37de5ec66eca805b9e858e537";
        $adm->escola_id = 1;
        $adm->save();
    }
}
