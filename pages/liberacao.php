<?php
include('../config/conexao.php');


if (isset($_SESSION['nivel'])) {
    if ($_SESSION['nivel'] !== 3) {
        $msgType = urlencode('error');
        $msg = urlencode('Você não tem acesso à página de liberação de discentes.');
        header("Location: home.php?sisco=corpoDoscente&msgType=$msgType&msg=$msg");
    }
}

$discentesSelect = "SELECT tb_jmf_discente.*, tb_jmf_turma.turma_serie, tb_jmf_turma.turma_nome
           FROM tb_jmf_discente
           JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
           WHERE tb_jmf_turma.turma_ano >= " . (date("Y") - 2) . "
           ORDER BY tb_jmf_discente.discente_nome ASC";


try {
    $resultDiscentes = $conexao->prepare($discentesSelect);
    $resultDiscentes->execute();

    $discentes = $resultDiscentes->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}


$registrosPorPagina = 20;

// Verificar a página atual
if (isset($_GET['pagina'])) {
    $paginaAtual = $_GET['pagina'];
} else {
    $paginaAtual = 1;
}

// Calcular o offset para a consulta SQL
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Consulta SQL para obter as liberações com paginação
$liberacoesSelect = "SELECT tb_sisco_liberacao.liberacao_id, tb_sisco_liberacao.liberacao_dtSaida, tb_sisco_liberacao.liberacao_hrSaida, tb_sisco_liberacao.liberacao_dtRetorno, tb_sisco_liberacao.liberacao_hrRetorno, tb_jmf_colaborador.colaborador_nome, tb_sisco_liberacao.liberacao_observacao, tb_sisco_liberacao.liberacao_idDiscente
           FROM tb_sisco_liberacao
           JOIN tb_jmf_colaborador ON tb_sisco_liberacao.liberacao_idColaboradorSaida = tb_jmf_colaborador.colaborador_matricula
           ORDER BY tb_sisco_liberacao.liberacao_id DESC LIMIT :offset, :registrosPorPagina";

try {
    $stmtLiberacoes = $conexao->prepare($liberacoesSelect);
    $stmtLiberacoes->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmtLiberacoes->bindValue(':registrosPorPagina', $registrosPorPagina, PDO::PARAM_INT);
    $stmtLiberacoes->execute();
    $liberacoes = $stmtLiberacoes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}

// Consulta SQL para contar o total de registros
$totalRegistrosSelect = "SELECT COUNT(*) AS totalRegistros FROM tb_sisco_liberacao";

try {
    $stmtTotalRegistros = $conexao->prepare($totalRegistrosSelect);
    $stmtTotalRegistros->execute();
    $totalRegistros = $stmtTotalRegistros->fetch(PDO::FETCH_ASSOC)['totalRegistros'];
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}

// Calcular o total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

?>

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
        } else {
            echo 'msgType não lido';
        }
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de Liberações</h5>
                    <form method="POST" action="../operations/postLiberacao.php">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="inputNome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="inputNome" placeholder="Digite o nome do(a) discente" list="discentes" onchange="preencherCampos()" required>
                                    <datalist id="discentes">
                                        <?php foreach ($discentes as $discente) : ?>
                                            <option value="<?php echo $discente->discente_nome; ?>">
                                            <?php endforeach; ?>
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="inputMatricula" class="form-label">Matrícula</label>
                                    <input type="text" class="form-control" id="inputMatricula" placeholder="Matrícula" readonly required name="discente_matricula">
                                </div>
                                <div class="mb-3">
                                    <label for="inputEmail" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="inputEmail" placeholder="E-mail" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputTurma" class="form-label">Turma</label>
                                    <input type="text" class="form-control" id="inputTurma" placeholder="Turma" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoLiberacao" class="form-label">Tipo da liberação</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipoLiberacao" id="inputEntrada" value="retorno" required>
                                        <label class="form-check-label" for="inputEntrada">Entrada</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipoLiberacao" id="inputSaida" value="saida" required checked>
                                        <label class="form-check-label" for="inputSaida">Saída</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="inputData" class="form-label">Data</label>
                                    <input type="date" class="form-control" id="inputDataEntrada" name="liberacao_dt" required value="<?php echo date("Y-m-d") ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputHora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="inputHoraEntrada" name="liberacao_hr" value="<?php echo date("H:i") ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputObservacoes" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="inputObservacoes" name="liberacao_observacao" placeholder="Descreva a liberação." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h6>Liberações</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Nº</th>
                                    <th class="text-center">Discente</th>
                                    <th class="text-center">Data e Hora Saída</th>
                                    <th class="text-center">Data e Hora Entrada</th>
                                    <th class="text-center">Observação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = ($paginaAtual - 1) * $registrosPorPagina + 1;
                                foreach ($liberacoes as $liberacao) {
                                    // Resto do código
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $contador; ?></td>
                                        <?php
                                        $discenteSelect = "SELECT discente_nome FROM tb_jmf_discente WHERE discente_matricula = :matricula";
                                        try {
                                            $stmtDiscente = $conexao->prepare($discenteSelect);
                                            $stmtDiscente->bindValue(':matricula', $liberacao['liberacao_idDiscente']);
                                            $stmtDiscente->execute();
                                            $nomeDiscente = $stmtDiscente->fetch(PDO::FETCH_ASSOC)['discente_nome'];
                                        } catch (PDOException $e) {
                                            echo "<b>Erro: </b>" . $e->getMessage();
                                        }
                                        ?>
                                        <td class="text-center"><?php echo $nomeDiscente; ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($liberacao['liberacao_dtSaida'] && $liberacao['liberacao_hrSaida']) {
                                                echo date('d/m/Y', strtotime($liberacao['liberacao_dtSaida'])) . '<br>' . date('H:i', strtotime($liberacao['liberacao_hrSaida']));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($liberacao['liberacao_dtRetorno'] && $liberacao['liberacao_hrRetorno']) {
                                                echo date('d/m/Y', strtotime($liberacao['liberacao_dtRetorno'])) . '<br>' . date('H:i', strtotime($liberacao['liberacao_hrRetorno']));
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?php echo !empty($liberacao['liberacao_observacao']) ? $liberacao['liberacao_observacao'] : '-'; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <a href="home.php?sisco=detalhesLiberacao&idLiberacao=<?php echo $liberacao['liberacao_id']; ?>" class="btn btn-primary">Detalhes</a>
                                        </td>
                                    </tr>
                                <?php
                                    $contador++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <ul class="pagination justify-content-center">
                                <?php if ($totalPaginas > 1) { ?>
                                    <?php if ($paginaAtual > 1) { ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo ($paginaAtual - 1); ?>">Anterior</a></li>
                                    <?php } ?>
                                    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                                        <li class="page-item <?php if ($i == $paginaAtual) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php } ?>
                                    <?php if ($paginaAtual < $totalPaginas) { ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?php echo ($paginaAtual + 1); ?>">Próxima</a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function preencherCampos() {
        var nome = document.getElementById('inputNome').value;
        var discentes = <?php echo json_encode($discentes); ?>;

        for (var i = 0; i < discentes.length; i++) {
            if (discentes[i].discente_nome === nome) {
                document.getElementById('inputMatricula').value = discentes[i].discente_matricula;
                document.getElementById('inputEmail').value = discentes[i].discente_email;
                document.getElementById('inputTurma').value = discentes[i].turma_serie + ' - ' + discentes[i].turma_nome;
                break;
            }
        }
    }
</script>