@extends('layout.main')

@section('title', 'SisCO')

@section('content')
    <div id="cadastro-ocorrencias" class="bloco cad">
        <div class="header">
            <h1>Cadastro de Ocorrências</h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/ocorrencia" method="POST" autocomplete="on" id="form">
                    @csrf
                    <div class="line">
                        <input type="text" name="nome" id="iNome" placeholder="Nome do aluno" class="w70"
                            list="alunos" autocomplete="off">
                        <datalist id="alunos">
                            @for ($i = 0; $i < count($alunos); $i++)
                                <option value="{{ $alunos[$i]->nome_aluno }}">{{ $alunos[$i]->nome_aluno }}</option>
                            @endfor
                        </datalist>
                        <input type="number" name="matricula" id="iMatricula" placeholder="Matrícula" disabled
                            class="w30" required>
                    </div>
                    <div class="line">
                        <input type="email" name="email" id="iEmail" placeholder="E-mail institucional" disabled
                            class="w70" autocomplete="email" required>
                        <input type="text" name="ano" id="iAno" placeholder="Série + Curso" disabled
                            class="w30" required>
                    </div>
                    <div class="line">
                        <input type="time" name="hora" id="iHora" class="w50">
                        <input type="date" name="data" id="iData" class="w50">
                    </div>
                    <div class="line wrap">
                        <div class="item-radio"><input type="radio" name="motivo" value="Telefone" id="telefone"><label
                                for="telefone">Telefone</label></div>
                        <div class="item-radio"><input type="radio" name="motivo" value="Namoro" id="namoro"><label
                                for="namoro">Namoro</label></div>
                        <div class="item-radio"><input type="radio" name="motivo" value="Desrespeito"
                                id="desrespeito"><label for="desrespeito">Desrespeito</label></div>
                        <div class="item-radio"><input type="radio" name="motivo" value="Conversa" id="conversa"><label
                                for="conversa">Conversa</label></div>
                        <div class="item-radio"><input type="radio" name="motivo" value="Fardamento"
                                id="fardamento"><label for="fardamento">Fardamento</label></div>
                        <div class="item-radio"><input type="radio" name="motivo" value="Outro" id="outro"><label
                                for="outro">Outro</label></div>
                    </div>
                    <textarea placeholder="Observação" name="obs"></textarea>
                    <button id="concluir" type="submit"><span>Concluir</span></button>
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
            <h1>Relatório Básico</h1>
        </div>
        <div class="table-body">
            <table>
                <tr>
                    <th class="alinhado-esquerda" scope="col">TURMA</th>
                    <th class="short" scope="col">OCORRÊNCIAS</th>
                    <th class="short" scope="col">ALERTAS</th>
                </tr>
                @if ($temOcorrencia != false)
                    @for ($c = 0; $c < count($turmas); $c++)
                        {{-- Contagem para cada aluno --}}
                        @if ($numeroOcorrencias($turmas[$c]) != 0)
                            <tr>
                                <td class="bold">
                                    <a href="/relturmas/{{ $turmas[$c]->id }}" hreflang="pt-BR" target="_self"
                                        class="hover-underline">
                                        {{ date('Y') - $turmas[$c]->ano + 1 }}º Ano - @php echo $nomeCurso($turmas[$c]); @endphp
                                    </a>
                                </td>
                                <td class="num">@php echo $numeroOcorrencias($turmas[$c]) @endphp</td>
                                <td class="num">@php echo $numeroAlertas($turmas[$c]) @endphp</td>
                            </tr>
                        @endif
                    @endfor
                @else
                    <h3>Ainda não há ocorrências registradas.</h3>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('alerts')
    @if (count($alertas) != 0)
        
        <div class="aside">
            <h1>> Pendências</h1>
            <div class="box-alertas">
                @foreach ($alertas as $alerta)
                    <div class="alerta">
                        <div class="icon">
                            <ion-icon name="pin-outline"></ion-icon>
                        </div>
                        <h2>{{ $pegaNomeAluno($alerta->aluno_id) }}</h2>

                        @foreach ($pegaMotivosAlerta($alerta) as $motivo)
                            {{-- <p>{{ $pegaDescricao($motivo) }}</p> --}}
                            {{ $motivo }},
                        @endforeach

                        <div class="formulario">

                            <button data-bs-toggle="modal" data-bs-target="#modal">Ver</button>

                            <div class="modal" tabindex="-1" id="modal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $pegaNomeAluno($alerta->aluno_id) }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>O presente aluno recebeu um alerta por:</p>
                                            <ul>
                                                @foreach ($pegaMotivosAlerta($alerta) as $motivo)
                                                    <li>{{ $motivo }}</li>
                                                @endforeach
                                            </ul>
                                            <h4>Dados do Aluno:</h4>
                                            <p><span>Nome: </span>{{ $objAluno($alerta->aluno_id)->nome_aluno }}</p>
                                            <p><span>Turma: </span>{{ $getTurma($objAluno($alerta->aluno_id)->turmas_id) }}
                                            </p>
                                            <p><span>Matrícula: </span>{{ $objAluno($alerta->aluno_id)->matricula }}</p>
                                            <h4>Dados do Responsável</h4>
                                            <p><span>Nome Responsável:
                                                </span>{{ $objAluno($alerta->aluno_id)->nome_responsavel }}</p>
                                            <p><span>Endereço: </span>{{ $objAluno($alerta->aluno_id)->end_responsavel }}
                                            </p>
                                            <p><span>Telefone para contato:
                                                </span>{{ $objAluno($alerta->aluno_id)->tel_responsavel }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-blue"
                                                data-bs-dismiss="modal">Fechar</button>
                                                <form action="/concluido/{{ $alerta->id }}" id="form_{{ $alerta->aluno_id }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-blue" form="form_{{ $alerta->aluno_id }}">Marcar como
                                                        concluído</button>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Aqui estava pensando em deixar como um botãozin simples
    Tipo, você aperta em abrir
    e lá dentro tem a ação de excluir o alerta
    e assim o número do banco de dados presente na tabela de alunos (diminui?) 
    Enfim, lá terá o botão de colocar como concluído e enfim ele será posto 1 
    no banco de dados e enfim não será mostrado 
    Acho que deu pra entender --}}
    @endif
@endsection
