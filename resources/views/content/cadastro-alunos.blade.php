z
@extends('layout.main')

@section('title', 'Cadastrando alunos')

@section('content')
    <div class="main">
        <div class="vetor">
            <img src="/img/novoAluno.svg" alt="Vetorização">
        </div>
        <div class="cadastro">
            <div class="header">
                <h1>Cadastro Novos Alunos</h1>
                {{-- Colocar rota para ir para a parte de CSV --}}
                <a href="/cadastro-por-csv" class="cadAluno">Cadastro por CSV</a>
            </div>
            <form action="/aluno" method="POST" autocomplete="off" id="form" autocomplete="off">
                @csrf
                <div class="line">
                    <input type="text" name="nome" id="iNome" placeholder="Nome do aluno" class="w100 uppercase">
                </div>
                <div class="line">
                    <input type="email" name="email" id="iEmail" placeholder="E-mail" class="w50">
                    <input type="number" name="matricula" placeholder="Matrícula" id="matricula" class="w50">
                </div>
                <div class="line">
                    <input type="date" name="dataN" id="iDataN" placeholder="dd/mm/aaaa" class="w50">
                    <input type="text" name="turma" id="iTurma" list="iTurmas" class="w50" placeholder="Turma do aluno">
                    <datalist id="iTurmas">
                        @foreach ($turmas as $turma)
                        <option value="{{ date("Y") - $turma->ano + 1 }}º Ano - @php echo $nomeCurso($turma); @endphp">{{ date("Y") - $turma->ano + 1 }}º Ano - @php echo $nomeCurso($turma); @endphp</option>
                    @endforeach
                    </datalist>
                </div>
                <div class="line">
                    <input type="text" name="nomeResponsavel" id="iNomeResponsavel" placeholder="Nome do(a) responsável" class="w100 uppercase">
                </div>
                <div class="line">
                    <input type="text" name="end" id="iEnd" placeholder="Endereço do responsável" class="w50">
                    <input type="tel" name="telResponsavel" id="iTelResponsavel" class="w50" placeholder="Telefone do responsável">
                </div>
                <button id="cadastrar" class="cadAluno"><span>Cadastrar</span></button>
                @if (session('msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('err'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('err') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </form>
        </div>
    </div>
    {{-- <div class="bloco cad">
        <div class="header">
            <h1>Cadastrando novos alunos</h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/aluno" method="POST" autocomplete="off" id="iForm" autocomplete="off">
                    @csrf
                <form action="/aluno-csv" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="iPlanilha">Cadastre por arquivo CSV: </label>
                    <input type="file" name="planilha" id="iPlanilha"> 
                    <button type="submit" id="cadastrar"><span>Cadastrar</span></button>
                </form>
            </div>
        </div>
    </div> --}}
@endsection