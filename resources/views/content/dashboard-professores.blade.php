@extends('layout.main')

@section('title', 'Dashboard Professores')

@section('content')
    <div class="bloco cad">
        <div class="header">
            <h1>Cadastro de professores</h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/novoprofessor" method="POST" enctype="multipart/form-data" id="formProf">
                    @csrf
                    <div class="line">
                        <input type="text" name="nome" id="iNome" placeholder="Nome professor"
                            class="w100 uppercase" required>
                    </div>
                    <div class="line">
                        <input type="email" name="email" id="iEmail" placeholder="E-mail professor" class="w100"
                            autocomplete="email" required>
                    </div>
                    <div class="line">
                        <input type="date" name="dataN" id="iDataN" placeholder="dd/mm/aaaa" class="w50"
                            required>
                        <input type="tel" name="tel" id="iTel" placeholder="(**) *.****-****" class="w50"
                            required>
                    </div>
                    <div class="line">
                        <input type="password" name="senha" id="iSenha" placeholder="Senha" class="w30"
                            minlength="8" required>
                    </div>
                    {{-- <div class="line">
                        <input type="file" name="foto" id="iFoto" placeholder="Arquivo de foto" class="w70">
                    </div> --}}
                    <button id="cadastrar" type="submit" name="btn"><span>Cadastrar</span></button>
                </form>
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bloco tab">
        <div class="header">
            <h1>Corpo docente escolar</h1>
        </div>
        <div class="table-body">
            <table>
                <tr>
                    <th class="alinhado-esquerda" scope="col">NOME</th>
                    <th class="short" scope="col">FUNÇÃO</th>
                    <th class="short" scope="col">TELEFONE</th>
                    <th scope="col">AÇÕES</th>
                </tr>
                {{-- Fazer contagem depois para quando não houver registro no banco --}}
                @if (count($corpoDocente) != 0)
                    @foreach ($corpoDocente as $user)
                        @if ($user->nome_user != 'Coordenador excluído do sistema')
                            @if ($user->nome_user != 'SISCO ADM')
                                <tr>
                                    <td class="bold"><a href="/editProf/{{ $user->id }}" class="hover-underline"
                                            hreflang="pt-BR" target="_self">{{ $user->nome_user }}</a></td>
                                    <td class="meio cinza">{{ $user->tipo_user }}</td>
                                    <td class="num">{{ $user->tel_user }}</td>
                                    <td class="">
                                        <div class="acoes">
                                            <a href="/editProf/{{ $user->id }}" class="edit" hreflang="pt-BR"
                                                target="_self">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </a>
                                            <form action="/delProf/{{ $user->id }}" id="form_{{ $user->id }}"
                                                class="delete-form" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete" hreflang="pt-BR" target="_self"
                                                    form="form_{{ $user->id }}" onclick="return confimarExclusao()">
                                                    <ion-icon name="close-circle-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @else
                    <h3>Não há usuários no banco.</h3>
                @endif
            </table>
        </div>
    </div>
@endsection
