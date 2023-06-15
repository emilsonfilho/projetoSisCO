    @extends('layout.main')

    @section('title', 'SisCO')

    @section('content')
        @if ($tipoUser == 'PROFESSOR')
            <style>
                main>div.bloco {
                    max-width: 1000px;
                }
            </style>
        @endif
        @if ($tipoUser == 'Administrador')
            <div id="cadastro-ocorrencias" class="bloco cad">
                <div class="header">
                    <h1>Cadastro de Ocorrências</h1>
                </div>
                <div class="body">
                    <div class="body-form">
                        <form action="/ocorrencia" method="POST" autocomplete="on" id="form">
                            @csrf
                            <div class="line">
                                <input type="text" name="nomeAluno" id="nome_aluno" placeholder="Nome do aluno"
                                    class="w70" list="alunos" autocomplete="off">
                                @php
                                    $students = [];
                                    $cursos = [];
                                    $turmasJS = [];
                                @endphp
                                <datalist id="alunos">
                                    @for ($i = 0; $i < count($alunos); $i++)
                                        <option value="{{ $alunos[$i]->discente_nome }}">{{ $alunos[$i]->discente_nome }}</option>
                                        @php
                                            $students[] = $alunos[$i];
                                            $cursos[] = $getCursoNome($alunos[$i]->discente_idTurma);
                                            $turmasJS[] = $getTurma($alunos[$i]->discente_idTurma);
                                        @endphp
                                    @endfor
                                </datalist>
                                @php
                                    
                                @endphp

                                @php
                                    echo '<script>
                                        ';
                                        echo 'var alunosJS = '.json_encode($students).
                                        ";";
                                        echo 'var cursos = '.json_encode($cursos).
                                        ";";
                                        echo 'var turmas = '.json_encode($turmasJS).
                                        ";";
                                        echo '
                                    </script>';
                                @endphp

                                <input type="text" name="matricula" id="iMatricula" placeholder="Matrícula" disabled
                                    class="w30" required>
                            </div>
                            <div class="line">
                                <input type="email" name="email" id="iEmail" placeholder="E-mail institucional"
                                    disabled class="w70" autocomplete="email" required>
                                <input type="text" name="ano" id="iAno" placeholder="Série + Curso" disabled
                                    class="w30" required>
                            </div>
                            <div class="line">
                                <input type="time" name="hora" id="iHora" class="w50">
                                <input type="date" name="data" id="iData" class="w50">
                            </div>
                            <div class="line wrap">
                                {{-- OBS: esses valores serão conforme o banco de dados mais para o frente --}}
                                @foreach ($motivosOcorrencias as $motivo)    
                                    <div class="item-radio">
                                        <input type="radio" name="motivo" value={{ $motivo->ocorrenciaMotivo_id }} id={{ $motivo->ocorrenciaMotivo_id }}>
                                        <label for="telefone">{{ $motivo->ocorrenciaMotivo_nome }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <textarea placeholder="Observação" name="obs"></textarea>
                            <button id="concluir" type="submit"><span>Concluir</span></button>
                            <script>
                                let input = document.getElementById("nome_aluno")
                                let email = document.getElementById('iEmail')
                                let matricula = document.getElementById('iMatricula')
                                let turma = document.getElementById('iAno')
                                input.addEventListener('change', function() {
                                    let nome = input.value
                                    for (let i = 0; i < alunosJS.length; i++) {
                                        if (alunosJS[i].discente_nome === nome) {
                                            email.value = alunosJS[i].discente_email
                                            matricula.value = alunosJS[i].discente_matricula
                                            turma.value = turmas[i]
                                        }
                                    }
                                })
                            </script>
                        </form>
                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('msg') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        @endif

        <div class="bloco tab">
            <div class="header">
                <h1>Relatório Básico</h1>
            </div>
            <div class="table-body">
                <table>
                    <tr>
                        <th class="alinhado-esquerda" scope="col">TURMA</th>
                        <th class="short" scope="col">OCORRÊNCIAS</th>
                        <th class="short" scope="col">EVENTOS</th>
                    </tr>
                    @if ($temOcorrencia != false)
                        @for ($c = 0; $c < count($turmas); $c++)
                            {{-- Contagem para cada aluno --}}
                            @if ($numeroOcorrencias($turmas[$c]) != 0)
                                <tr>
                                    <td class="bold">
                                        <a href="/relturmas/{{ $turmas[$c]->turma_id }}" hreflang="pt-BR" target="_self"
                                            class="hover-underline">
                                            {{ date('Y') - $turmas[$c]->turma_ano + 1 }}º Ano - @php echo $nomeCurso($turmas[$c]); @endphp
                                        </a>
                                    </td>
                                    <td class="num">@php echo strval($numeroOcorrencias($turmas[$c])) @endphp</td>
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
        @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
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
                                    <p class="motivo">{{ $motivo }}</p>
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
                                                    <p><span>Turma:
                                                        </span>{{ $getTurma($objAluno($alerta->aluno_id)->turmas_id) }}
                                                    </p>
                                                    <p><span>Matrícula:
                                                        </span>{{ $objAluno($alerta->aluno_id)->matricula }}</p>
                                                    <h4>Dados do Responsável</h4>
                                                    <p><span>Nome Responsável:
                                                        </span>{{ $objAluno($alerta->aluno_id)->nome_responsavel }}</p>
                                                    <p><span>Endereço:
                                                        </span>{{ $objAluno($alerta->aluno_id)->end_responsavel }}
                                                    </p>
                                                    <p><span>Telefone para contato:
                                                        </span>{{ $objAluno($alerta->aluno_id)->tel_responsavel }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-blue"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                    <form action="/concluido/{{ $alerta->id }}"
                                                        id="form_{{ $alerta->aluno_id }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-blue"
                                                            form="form_{{ $alerta->aluno_id }}">Marcar como
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
            @endif
        @endif
    @endsection
