@extends('layout.main-pure')

@section('title', 'Editando: ' . $aluno->nome_aluno)

@section('content')
    <div class="bloco cad marTop">
        <div class="header btn-voltar">
            <h1>Editando: <span>{{ $aluno->nome_aluno }}</span></h1>
            <a href="#" id="btnBack"><img src="/img/btnvoltar.svg" alt=""></a>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/updateAluno/{{ $aluno->id }}" method="POST" enctype="multipart/form-data" id="formCadastro">
                    @csrf
                    @method('PUT')
                    <div class="line">
                        <input type="text" name="nomeAluno" id="iNomeAluno" placeholder="Nome aluno"
                            class="w100 uppercase" value="{{ $aluno->nome_aluno }}" required>
                    </div>
                    <div class="line">
                        <input type="email" name="email" id="iEmail" placeholder="E-mail institucional" class="w100"
                            autocomplete="email" value="{{ $aluno->email_aluno }}" required>
                    </div>
                    <div class="line">
                        <input type="number" name="matricula" id="iMatricula" value="{{ $aluno->matricula }}" class="w30">
                        <select name="serie" id="iSerie" class="w30">
                            <option value="{{ date("Y") }}">1º Ano</option>
                            <option value="{{ date("Y") - 1}}">2º Ano</option>
                            <option value="{{ date("Y") - 2}}">3º Ano</option>
                        </select>
                        <select name="curso" id="iCurso" class="w40">
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nome_curso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="line">
                        <input type="date" name="dataN" id="iDataN" placeholder="dd/mm/aaaa" class="w50" value="{{ $aluno->dataN_aluno }}"
                            required>
                    </div>
                    <h3>Dados do Responsável</h3>
                    <div class="line">
                        <input type="text" name="nomeResponsavel" id="iNomeResponsavel" placeholder="Nome do responsável" value="{{ $aluno->nome_responsavel }}" class="w100" style="text-trans">
                    </div>
                    <div class="line">
                        <input type="text" name="end" id="iEnd" placeholder="Endereço do responsável" class="w70"  value="{{ $aluno->end_responsavel }}">
                        <input type="tel" name="telResponsavel" id="iTelResponsavel" placeholder="(**) *.****-****" value="{{ $aluno->tel_responsavel }}">
                    </div>
                    <button id="editar" type="submit" name="btn"><span>Editar</span></button>
                </form>
            </div>
            
        </div>
    </div>
@endsection
