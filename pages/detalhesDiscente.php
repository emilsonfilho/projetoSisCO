<?php
include_once("../config/conexao.php");
require_once("../utils/formatarDataHora.php");

// Verifica se a matrícula do aluno foi fornecida na URL
if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Consulta os dados do aluno
    $query = "SELECT tb_jmf_discente.discente_matricula, tb_jmf_discente.discente_nome, tb_jmf_turma.turma_serie, tb_jmf_curso.curso_nome, tb_jmf_responsavellegal.responsavelLegal_nome,
        tb_jmf_discente.discente_dataNascimento, tb_jmf_discente.discente_naturalidade, tb_jmf_discente.discente_corRaca, tb_jmf_discente.discente_sexo,
        tb_jmf_discente.discente_telefone, tb_jmf_discente.discente_email, tb_jmf_discente.discente_cpf, tb_jmf_discente.discente_cep, tb_jmf_discente.discente_tipoLogradouro,
        tb_jmf_discente.discente_nomeLogradouro, tb_jmf_discente.discente_bairro, tb_jmf_discente.discente_cidade, tb_jmf_discente.discente_estado
FROM tb_jmf_discente
INNER JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
INNER JOIN tb_jmf_curso ON tb_jmf_turma.turma_idCurso = tb_jmf_curso.curso_id
INNER JOIN tb_jmf_responsavellegal ON tb_jmf_discente.discente_idResponsavel = tb_jmf_responsavellegal.responsavelLegal_id
WHERE tb_jmf_discente.discente_matricula = :matricula";

    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':matricula', $matricula);
    $stmt->execute();
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o aluno foi encontrado
    if ($aluno) {
        // Formata a data de nascimento
        $dataNascimento = date('d/m/Y', strtotime($aluno['discente_dataNascimento']));

        // Consulta as ocorrências do aluno
        $queryOcorrencias = "SELECT tb_sisco_ocorrencia.ocorrencia_id, tb_sisco_ocorrenciamotivo.ocorrenciaMotivo_nome, tb_sisco_ocorrencia.ocorrencia_descricao, tb_sisco_ocorrencia.ocorrencia_data, tb_sisco_ocorrencia.ocorrencia_hora, tb_jmf_colaborador.colaborador_nome
FROM tb_sisco_ocorrencia
INNER JOIN tb_sisco_ocorrenciamotivo ON tb_sisco_ocorrencia.ocorrencia_idMotivo = tb_sisco_ocorrenciamotivo.ocorrenciaMotivo_id
INNER JOIN tb_jmf_colaborador ON tb_sisco_ocorrencia.ocorrencia_idColaborador = tb_jmf_colaborador.colaborador_matricula
WHERE tb_sisco_ocorrencia.ocorrencia_idDiscente = :matricula";

        $stmtOcorrencias = $conexao->prepare($queryOcorrencias);
        $stmtOcorrencias->bindParam(':matricula', $matricula);
        $stmtOcorrencias->execute();
        $ocorrencias = $stmtOcorrencias->fetchAll(PDO::FETCH_ASSOC);

        // Formata as ocorrências para exibição
        $ocorrenciasFormatadas = array();
        foreach ($ocorrencias as $index => $ocorrencia) {
            $ocorrenciasFormatadas[$index]['numero'] = $index + 1;
            $ocorrenciasFormatadas[$index]['motivo'] = $ocorrencia['ocorrenciaMotivo_nome'];
            $ocorrenciasFormatadas[$index]['descricao'] = !empty($ocorrencia['ocorrencia_descricao']) ? $ocorrencia['ocorrencia_descricao'] : '-';
            $ocorrenciasFormatadas[$index]['data_hora'] = formatarDataHora($ocorrencia['ocorrencia_data'], $ocorrencia['ocorrencia_hora']);
            $ocorrenciasFormatadas[$index]['responsavel'] = $ocorrencia['colaborador_nome'];
            $ocorrenciasFormatadas[$index]['id'] = $ocorrencia['ocorrencia_id'];
        }

        $queryEventos = "SELECT tb_sisco_evento.evento_id, tb_sisco_eventomotivo.eventoMotivo_nome, tb_sisco_evento.evento_observacao, tb_sisco_evento.evento_data, tb_sisco_evento.evento_hora, tb_jmf_colaborador.colaborador_nome
        FROM tb_sisco_evento
        INNER JOIN tb_sisco_eventomotivo ON tb_sisco_evento.evento_idMotivo = tb_sisco_eventomotivo.eventoMotivo_id
        INNER JOIN tb_jmf_colaborador ON tb_sisco_evento.evento_idColaborador = tb_jmf_colaborador.colaborador_matricula
        WHERE tb_sisco_evento.evento_idDiscente = :matricula";

        $stmtEventos = $conexao->prepare($queryEventos);
        $stmtEventos->bindParam(':matricula', $matricula);
        $stmtEventos->execute();
        $eventos = $stmtEventos->fetchAll(PDO::FETCH_ASSOC);

        // Formata os eventos para exibição
        $eventosFormatados = array();
        foreach ($eventos as $index => $evento) {
            $eventosFormatados[$index]['numero'] = $index + 1;
            $eventosFormatados[$index]['motivo'] = $evento['eventoMotivo_nome'];
            $eventosFormatados[$index]['observacao'] = !empty($evento['evento_observacao']) ? $evento['evento_observacao'] : '-';
            $eventosFormatados[$index]['data_hora'] = date('d/m/Y H:i', strtotime($evento['evento_data'] . ' ' . $evento['evento_hora']));
            $eventosFormatados[$index]['responsavel'] = $evento['colaborador_nome'];
            $eventosFormatados[$index]['id'] = $evento['evento_id'];
        }

        $queryLiberacoes = "SELECT 
                        tb_jmf_discente.discente_nome, 
                        tb_sisco_liberacao.liberacao_id,
                        tb_sisco_liberacao.liberacao_dtSaida, 
                        tb_sisco_liberacao.liberacao_hrSaida, 
                        tb_sisco_liberacao.liberacao_dtRetorno, 
                        tb_sisco_liberacao.liberacao_hrRetorno, 
                        tb_sisco_liberacao.liberacao_observacao, 
                        tb_jmf_responsavellegal.responsavelLegal_nome,
                        colSaida.colaborador_nome AS colaborador_saida_nome,
                        colRetorno.colaborador_nome AS colaborador_retorno_nome
                    FROM 
                       tb_sisco_liberacao
                    JOIN 
                       tb_jmf_discente ON tb_sisco_liberacao.liberacao_idDiscente = tb_jmf_discente.discente_matricula
                    JOIN 
                       tb_jmf_colaborador colSaida ON tb_sisco_liberacao.liberacao_idColaboradorSaida = colSaida.colaborador_matricula
                    JOIN 
                       tb_jmf_colaborador colRetorno ON tb_sisco_liberacao.liberacao_idColaboradorRetorno = colRetorno.colaborador_matricula
                    JOIN
                        tb_jmf_responsavellegal ON tb_sisco_liberacao.liberacao_idResponsavel = tb_jmf_responsavellegal.responsavelLegal_id
                    WHERE 
                       tb_jmf_discente.discente_matricula = :matricula;

";

        $stmtLiberacoes = $conexao->prepare($queryLiberacoes);
        $stmtLiberacoes->bindParam(':matricula', $matricula);
        $stmtLiberacoes->execute();
        $liberacoes = $stmtLiberacoes->fetchAll(PDO::FETCH_ASSOC);

        $liberacoesFormatadas = array();
        foreach ($liberacoes as $index => $liberacao) {
            $liberacoesFormatadas[$index]['numero'] = $index + 1;
            $liberacoesFormatadas[$index]['dt_hr_saida'] = formatarDataHora($liberacao['liberacao_dtSaida'], $liberacao['liberacao_hrSaida']);
            $liberacoesFormatadas[$index]['colaborador_saida'] = $liberacao['colaborador_saida_nome'] ?? "-";
            $liberacoesFormatadas[$index]['dt_hr_retorno'] = ($liberacao['liberacao_dtRetorno'] || $liberacao['liberacao_hrRetorno']) ? formatarDataHora($liberacao['liberacao_dtRetorno'], $liberacao['liberacao_hrRetorno']) : "-";
            $liberacoesFormatadas[$index]['colaborador_retorno'] = $liberacao['colaborador_retorno_nome'] ?? "-";
            $liberacoesFormatadas[$index]['observacao'] = $liberacao['liberacao_observacao'] ?? "-";
            $liberacoesFormatadas[$index]['id'] = $liberacao['liberacao_id'];
        }
?>
        <script src="../operations/confirmDelete.js"></script>

        <div class="container">
            <?php
            // Verificar se a mensagem está presente na URL
            if (isset($_GET['msgType']) && isset($_GET['msg'])) {
                $msgType = $_GET['msgType'];
                $msg = $_GET['msg'];

                // Verificar o tipo de mensagem e exibir a mensagem correspondente
                if ($msgType === 'success') {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo urldecode($msg);
                    echo '</div>';
                } elseif ($msgType === 'error') {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo urldecode($msg);
                    echo '</div>';
                }
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <h3 class="text-center"><?php echo $aluno['discente_nome']; ?></h3>
                            <h5 class="text-center text-secondary"><?php echo $aluno['turma_serie'] . ' - ' . $aluno['curso_nome']; ?></h5>

                            <div class="mt-4">
                                <h6>Dados do Aluno</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Matrícula:</strong> <?php echo $aluno['discente_matricula']; ?></p>
                                        <p><strong>Série:</strong> <?php echo $aluno['turma_serie']; ?></p>
                                        <p><strong>Nome do Responsável:</strong> <?php echo $aluno['responsavelLegal_nome']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Curso:</strong> <?php echo $aluno['curso_nome']; ?></p>
                                        <p><strong>Data de Nascimento:</strong> <?php echo $dataNascimento; ?></p>
                                        <p><strong>Naturalidade:</strong> <?php echo $aluno['discente_naturalidade']; ?></p>
                                        <p><strong>Cor/Raça:</strong> <?php echo $aluno['discente_corRaca']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Sexo:</strong> <?php echo $aluno['discente_sexo']; ?></p>
                                        <p><strong>Telefone:</strong> <?php echo $aluno['discente_telefone']; ?></p>
                                        <p><strong>Email:</strong> <?php echo $aluno['discente_email']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>CPF:</strong> <?php echo $aluno['discente_cpf']; ?></p>
                                        <p><strong>Endereço:</strong> <?php echo $aluno['discente_tipoLogradouro'] . ' ' . $aluno['discente_nomeLogradouro'] . ', ' . $aluno['discente_bairro'] . ', ' . $aluno['discente_cidade'] . ', ' . $aluno['discente_estado']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <h6>Ocorrências do Aluno</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <?php
                                    if (!empty($ocorrencia)) {
                                    ?>
                                        <thead>
                                            <tr>
                                                <th class="text-center">nº</th>
                                                <th class="text-center">Motivo</th>
                                                <th class="text-center">Observação</th>
                                                <th class="text-center">Data e Hora</th>
                                                <th class="text-center">Coordenador Responsável</th>
                                                <?php
                                                if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                    // Exibe o botão de edição somente se o nível for 3
                                                ?>
                                                    <th class="text-center">Ações</th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ocorrenciasFormatadas as $ocorrencia) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $ocorrencia['numero']; ?></td>
                                                    <td class="text-center"><?php echo $ocorrencia['motivo']; ?></td>
                                                    <td class="text-center"><?php echo $ocorrencia['descricao']; ?></td>
                                                    <td class="text-center"><?php echo $ocorrencia['data_hora']; ?></td>
                                                    <td class="text-center"><?php echo $ocorrencia['responsavel']; ?></td>
                                                    <?php
                                                    if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                        // Exibe o botão de edição somente se o nível for 3
                                                    ?>
                                                        <td class="text-center">
                                                            <a href="home.php?sisco=editOcorrencia&idOcorrencia=<?php echo $ocorrencia['id']; ?>" class="btn btn-primary">Editar</a>
                                                            <form action="../operations/destroyOcorrencia.php" method="post" style="display: inline;" id="formDestroyOcorrencia">
                                                                <input type="hidden" name="idOcorrencia" value="<?php echo $ocorrencia['id']; ?>">
                                                                <button type="button" class="btn btn-danger" onclick="confirmarRemocao('essa ocorrência', '#formDestroyOcorrencia')">Remover</button>
                                                            </form>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php
                                    } else {
                                    ?>
                                        <p>O aluno não possui ocorrências.</p>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <h6>Eventos do Aluno</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <?php
                                    if (!empty($evento)) {
                                    ?>
                                        <thead>
                                            <tr>
                                                <th class="text-center">nº</th>
                                                <th class="text-center">Motivo</th>
                                                <th class="text-center">Observação</th>
                                                <th class="text-center">Data e Hora</th>
                                                <th class="text-center">Coordenador Responsável</th>
                                                <?php
                                                if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                    // Exibe o botão de edição somente se o nível for 3
                                                ?>
                                                    <th class="text-center">Ações</th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($eventosFormatados as $evento) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $evento['numero']; ?></td>
                                                    <td class="text-center"><?php echo $evento['motivo']; ?></td>
                                                    <td class="text-center"><?php echo $evento['observacao']; ?></td>
                                                    <td class="text-center"><?php echo $evento['data_hora']; ?></td>
                                                    <td class="text-center"><?php echo $evento['responsavel']; ?></td>
                                                    <?php
                                                    if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                        // Exibe o botão de edição somente se o nível for 3
                                                    ?>
                                                        <td class="text-center">
                                                            <a href="home.php?sisco=editEvento&idEvento=<?php echo $evento['id']; ?>" class="btn btn-primary">Editar</a>
                                                            <form action="../operations/destroyEvento.php" method="post" style="display: inline;" id="formDestroyEvento">
                                                                <input type="hidden" name="idEvento" value="<?php echo $evento['id']; ?>">
                                                                <button type="button" class="btn btn-danger" onclick="confirmarRemocao('esse evento', '#formDestroyEvento')">Remover</button>
                                                            </form>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php
                                    } else {
                                    ?>
                                        <p>O aluno não possui eventos.</p>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <h6>Liberações do Aluno</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <?php
                                    // primeiro passo: query liberacoes
                                    if (!empty($liberacoes)) {
                                    ?>
                                        <thead>
                                            <tr class="align-middle">
                                                <th class="text-center">nº</th>
                                                <th class="text-center">Data e Hora Saída</th>
                                                <th class="text-center">Coordenador Responsável<br>Saída</th>
                                                <th class="text-center">Data e Hora Retorno</th>
                                                <th class="text-center">Coordenador Responsável<br>Retorno</th>
                                                <th class="text-center">Observação</th>
                                                <?php
                                                if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                    // Exibe o botão de edição somente se o nível for 3
                                                ?>
                                                    <th class="text-center">Ações</th>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($liberacoesFormatadas as $liberacao) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $liberacao['numero']; ?></td>
                                                    <td class="text-center"><?php echo $liberacao['dt_hr_saida']; ?></td>
                                                    <td class="text-center"><?php echo $liberacao['colaborador_saida']; ?></td>
                                                    <td class="text-center"><?php echo $liberacao['dt_hr_retorno']; ?></td>
                                                    <td class="text-center"><?php echo $liberacao['colaborador_retorno']; ?></td>
                                                    <td class="text-center"><?php echo $liberacao['observacao']; ?></td>
                                                    <?php
                                                    if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 3) {
                                                        // Exibe o botão de edição somente se o nível for 3
                                                    ?>
                                                        <td class="text-center">
                                                            <a href="home.php?sisco=editLiberacao&idLiberacao=<?php echo $liberacao['id']; ?>" class="btn btn-primary">Editar</a>
                                                            <form action="../operations/destroyLiberacao.php" method="post" style="display: inline;" id="formDestroyLiberacao">
                                                                <input type="hidden" name="idEvento" value="<?php echo $liberacao['id']; ?>">
                                                                <button type="button" class="btn btn-danger" onclick="confirmarRemocao('esse evento', '#formDestroyLiberacao')">Remover</button>
                                                            </form>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php
                                    } else {
                                    ?>
                                        <p>O aluno não possui eventos.</p>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    } else {
        echo "Aluno não encontrado.";
    }
} else {
    echo "Matrícula do aluno não encontrada.";
}
?>