@extends('layout.main')

@section('title', 'Cadastro por CSV')

@section('content')
<div class="bloco cad edicao">
    <div class="header">
        <h1>Cadastrando novos alunos</h1>
        <a href="cadAlunos"><img src="/img/btnvoltar.svg" alt=""></a>
    </div>
    <div class="body">
        <div class="body-form">
            <form action="/aluno-csv" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="iPlanilha">Cadastre por arquivo CSV: </label><br>
                <input type="file" name="planilha" id="iPlanilha"> <br>
                <button type="submit" id="cadastrar"><span>Cadastrar</span></button>
            </form>
        </div>
    </div>
</div>
@endsection
