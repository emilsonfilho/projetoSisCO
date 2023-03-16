<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlunosIdToOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->foreignId('alunos_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->foreignId('alunos_id')->constrained()->onDelete();
        });
    }
}
