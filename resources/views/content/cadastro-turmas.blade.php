@extends('layout.main')

@section('title', 'Cadastro De Turmas | SisCO')

@section('content')
    
    <div class="bloco cad">
        <div class="header">
            <h1>Cadastro de turmas</h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/novaturma" method="POST" id="formTurma">
                    @csrf
                    <div class="line">
                        <select name="ano" id="iAno" class="w25">
                            <option value="{{ date("Y") }}">1º Ano</option>
                            <option value="{{ date("Y") - 1 }}">2º Ano</option>
                            <option value="{{ date("Y") - 2 }}">3º Ano</option>
                        </select>
                        <select name="curso" id="iCurso" class="w50">
                            @if (count($cursos) != 0)
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->nome_curso }}</option>
                                @endforeach
                            @else
                                <option value="">Não há cursos. Por favor, cadastre-os.</option>
                            @endif
                        </select>
                        <a href="/cadCurso" class="new">Novo Curso</a>
                    </div>
                <button id="cadastrar" type="submit" class="btn" style="font-size: 1em;"><span>Cadastrar</span></button>
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
