@extends('layout.main   ')

@section('title', 'Relatório Individual')

@section('content')
    <link rel="stylesheet" href="/css/relatorioIndividual-header.css">
    <div class="bloco individual">
        <div class="header">
            <div class="voltar">
                <a href="#" id="btnBack"><img src="/img/btnvoltar.svg" alt="" style=""></a>
            </div>
            
            <div class="aluno">
                <h1>{{ $nome }}</h1>
                <p>{{ $turma }}</p>
            </div>
            <div class="actions">
                <a href="/editAluno/{{ $id }}" hreflang="pt-BR" id="editarAluno">
                    <ion-icon name="create-outline"></ion-icon>
                </a>
                <form action="/delAluno/{{ $id }}" method="post" id="form_{{ $id }}" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" form="form_{{ $id }}" class="delete" hreflang="pt-BR" target="_self"
                        onclick="return confimarExclusao()">
                        <ion-icon name="trash-outline"></ion-icon>
                    </button>
                </form>
            </div>
        </div>
        {{-- Aqui pode ser colocado a variável de $turma --}}
        {{-- Fonte: var(--poppins) --}}
        {{-- Uma boa propriedade p diminuir o tamanho da telra é o font-size --}}
        <div class="body">
            <div class="dados">
                <div class="dados-aluno">
                    <h3>DADOS PESSOAIS</h3>
                    <p><span>Nome: </span> {{ $nome }}</p>
                    <p><span>Série: </span> {{ $serie }}</p>
                    <p><span>Curso: </span> {{ $curso }}</p>
                    <p><span>Email: </span> {{ $email }}</p>
                    <p><span>Matrícula: </span> {{ $matricula }}</p>
                    <p><span>Data de Nacimento: </span> {{ $dataN }}</p>
                </div>
                <div class="dados-responsavel">
                    <h3>DADOS DO RESPONSÁVEL</h3>
                    <p><span>Nome do responsável: </span>{{ $nomeResponsavel }}</p>
                    <p><span>Endereço: </span>{{ $endereco }}</p>
                    <p><span>Telefone: </span>{{ $telefone }}</p>

                </div>
            </div>
            <div class="tab">
                <div class="table-body">
                    <table>
                        <tr>
                            <th>Nº</th>
                            <th>MOTIVO</th>
                            <th>OBSERVAÇÃO</th>
                            <th>DATA E HORA</th>
                            <th>COORDENADOR RESPONSÁVEL</th>
                        </tr>
                        @if (count($ocorrencias) != 0)
                            @foreach ($ocorrencias as $ocorrencia)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $ocorrencia->motivo }}</td>
                                    <td>{{ $ocorrencia->observacao }}</td>
                                    <td>{{ $formatarData($ocorrencia->data) }} - {{ $formatarHora($ocorrencia->hora) }}
                                    </td>
                                    <td>{{ $getCoordenador($ocorrencia->id) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <h4>O aluno não possui ocorrências</h4>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
