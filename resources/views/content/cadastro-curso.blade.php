@extends('layout.main')

@section('title', 'Cadastre um novo curso')
    
@section('content')
<div class="bloco cad edicao">
    <div class="header">
        <h1>Cadastro de novos curso</h1>
        <a href="/cadTurmas"><img src="/img/btnvoltar.svg" alt=""></a>
    </div>
    <div class="body">
        <div class="body-form">
            <form action="/novocurso" method="POST">
                @csrf
                <div class="line">
                    <input type="text" name="curso" id="iCurso" placeholder="Nome do Curso" required class="w100 uppercase">
                </div>
                <button id="cadastrar" type="submit" name="btn" style="font-size: 1em;"><span>Cadastrar</span></button>
            </form>
        </div>
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('err'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('err') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
    </div>
</div>
@endsection