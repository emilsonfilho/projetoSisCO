<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_aluno', 90);
            $table->integer('matricula');
            $table->string('email_aluno', 90);
            $table->date('dataN_aluno');
            $table->string('nome_responsavel', 90);
            $table->text('end_responsavel', 250);
            $table->string('tel_responsavel', 20);
            $table->integer('qntd_ocorrencias_assinadas');
            $table->integer('qntd_alertas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos');
    }
}
