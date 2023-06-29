<?php
include('../config/conexao.php');

if (isset($_SESSION['nivel'])) {
    if ($_SESSION['nivel'] !== 3) {
        $msgType = urlencode('error');
        $msg = urlencode('Você não tem acesso à página de cadastro de ocorrências.');
        header("Location: home.php?sisco=corpoDoscente&msgType=$msgType&msg=$msg");
    }
}

$discentesSelect = "SELECT tb_jmf_discente.*, tb_jmf_turma.turma_serie, tb_jmf_turma.turma_nome
           FROM tb_jmf_discente
           JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
           WHERE tb_jmf_turma.turma_ano >= " . (date("Y") - 2) . "
           ORDER BY tb_jmf_discente.discente_nome ASC";

$motivosSelect = "SELECT ocorrenciaMotivo_id, ocorrenciaMotivo_nome FROM tb_sisco_ocorrenciamotivo";


try {
    $resultDiscentes = $conexao->prepare($discentesSelect);
    $resultDiscentes->execute();

    $discentes = $resultDiscentes->fetchAll(PDO::FETCH_OBJ);

    $motivos = $conexao->query($motivosSelect)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo urldecode('Ocorreu um erro ao tentar carregar a página.');
    echo '</div>';
}
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
        }
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de Ocorrências</h5>
                    <form method="POST" action="../operations/postOcorrencia.php">
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
                            <label for="inputData" class="form-label">Data</label>
                            <input type="date" class="form-control" id="inputData" name="ocorrencia_data" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputHora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="inputHora" name="ocorrencia_hora" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputMotivo" class="form-label">Motivo</label>
                            <?php foreach ($motivos as $motivo) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ocorrencia_idMotivo" id="inputMotivo<?php echo $motivo['ocorrenciaMotivo_id']; ?>" value="<?php echo $motivo['ocorrenciaMotivo_id']; ?>" required>
                                    <label class="form-check-label" for="inputMotivo<?php echo $motivo['ocorrenciaMotivo_id']; ?>">
                                        <?php echo $motivo['ocorrenciaMotivo_nome']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mb-3">
                            <label for="inputObservacoes" class="form-label">Descrição</label>
                            <textarea class="form-control" id="inputObservacoes" name="ocorrencia_descricao" placeholder="Descreva a ocorrência." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Tabela de Dados -->
            <div class="card">
                <div class="card-header">
                    Dados de Ocorrências
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Turma</th>
                                    <th class="text-center">Ocorrências</th>
                                    <th class="text-center">Eventos</th>
                                    <!-- Adicione mais colunas conforme necessário -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $turmaSelect = "SELECT tb_jmf_turma.turma_id, tb_jmf_turma.turma_nome, tb_jmf_turma.turma_serie, 
                                        COUNT(DISTINCT tb_sisco_ocorrencia.ocorrencia_id) AS total_ocorrencias, 
                                        COUNT(DISTINCT tb_sisco_evento.evento_id) AS total_eventos
                                        FROM tb_jmf_turma
                                        INNER JOIN tb_jmf_discente ON tb_jmf_turma.turma_id = tb_jmf_discente.discente_idTurma
                                        LEFT JOIN tb_sisco_ocorrencia ON tb_jmf_discente.discente_matricula = tb_sisco_ocorrencia.ocorrencia_idDiscente
                                        LEFT JOIN tb_sisco_evento ON tb_jmf_discente.discente_matricula = tb_sisco_evento.evento_idDiscente
                                        GROUP BY tb_jmf_turma.turma_id";
                                try {
                                    $stmtTurmas = $conexao->prepare($turmaSelect);
                                    $stmtTurmas->execute();
                                    $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($turmas as $turma) {
                                        $turmaNome = $turma['turma_serie'] . "-" . $turma['turma_nome'];
                                        $totalOcorrencias = $turma['total_ocorrencias'];
                                        $totalEventos = $turma['total_eventos'];
                                        // Exibe a linha da tabela com os dados da turma
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $turmaNome; ?></td>
                                            <td class="text-center"><?php echo $totalOcorrencias; ?></td>
                                            <td class="text-center"><?php echo $totalEventos; ?></td>
                                        </tr>
                                <?php
                                    }
                                } catch (\Throwable $th) {
                                    // Tratamento de erro
                                }
                                ?>
                            </tbody>
                        </table>
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