<?php
include('../config/conexao.php');

if (isset($_SESSION['nivel'])) {
    if ($_SESSION['nivel'] !== 3) {
        $msgType = urlencode('error');
        $msg = urlencode('Você não tem acesso à página de edição de liberações.');
        header("Location: home.php?sisco=corpoDoscente&msgType=$msgType&msg=$msg");
    }
}

$discentesSelect = "SELECT tb_jmf_discente.*, tb_jmf_turma.turma_serie, tb_jmf_turma.turma_nome
                    FROM tb_jmf_discente
                    JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
                    WHERE tb_jmf_turma.turma_ano >= " . (date("Y") - 2) . "
                    ORDER BY tb_jmf_discente.discente_nome ASC";

$liberacaoSelect = "SELECT tb_sisco_liberacao.liberacao_dtSaida, tb_sisco_liberacao.liberacao_hrSaida, tb_sisco_liberacao.liberacao_observacao, tb_jmf_discente.discente_matricula
                    FROM tb_sisco_liberacao
                    JOIN tb_jmf_discente ON tb_sisco_liberacao.liberacao_idDiscente = tb_jmf_discente.discente_matricula
                    WHERE tb_sisco_liberacao.liberacao_id = :id";

try {
    $resultDiscentes = $conexao->prepare($discentesSelect);
    $resultDiscentes->execute();
    $discentes = $resultDiscentes->fetchAll(PDO::FETCH_OBJ);

    $resultLiberacao = $conexao->prepare($liberacaoSelect);
    $resultLiberacao->bindParam(':id', $_GET['idLiberacao'], PDO::PARAM_INT);
    $resultLiberacao->execute();
    $liberacao = $resultLiberacao->fetch(PDO::FETCH_OBJ);

    $discenteSelect = "SELECT tb_jmf_discente.discente_nome, tb_jmf_discente.discente_matricula, tb_jmf_discente.discente_email, tb_jmf_turma.turma_serie, tb_jmf_turma.turma_nome
                       FROM tb_jmf_discente
                       JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
                       WHERE tb_jmf_discente.discente_matricula = :matricula";

    $stmtDiscente = $conexao->prepare($discenteSelect);
    $stmtDiscente->bindParam(':matricula', $liberacao->discente_matricula);
    $stmtDiscente->execute();
    $discenteLiberacao = $stmtDiscente->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Edição de Liberação</h5>
                    <form method="POST" action="../operations/updateLiberacao.php?idLiberacao=<?php echo $_GET['idLiberacao']; ?>">
                        <div class="mb-3">
                            <label for="inputNome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputNome" placeholder="Digite o nome do(a) discente" list="discentes" onchange="preencherCampos()" required value="<?php echo $discenteLiberacao['discente_nome']; ?>">
                            <datalist id="discentes">
                                <?php foreach ($discentes as $discente) : ?>
                                    <option value="<?php echo $discente->discente_nome; ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="inputMatricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="inputMatricula" placeholder="Matrícula" readonly required name="discente_matricula" value="<?php echo $discenteLiberacao['discente_matricula']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="inputEmail" placeholder="E-mail" readonly required value="<?php echo $discenteLiberacao['discente_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputTurma" class="form-label">Turma</label>
                            <input type="text" class="form-control" id="inputTurma" placeholder="Turma" readonly required value="<?php echo $discenteLiberacao['turma_serie'] . ' - ' . $discenteLiberacao['turma_nome']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputData" class="form-label">Data de Saída</label>
                            <input type="date" class="form-control" id="inputDataEntrada" name="liberacao_dtSaida" required value="<?php echo $liberacao->liberacao_dtSaida; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputHora" class="form-label">Hora de Saída</label>
                            <input type="time" class="form-control" id="inputHoraEntrada" name="liberacao_hrSaida" value="<?php echo $liberacao->liberacao_hrSaida; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputData" class="form-label">Data de Retorno</label>
                            <input type="date" class="form-control" id="inputDataEntrada" name="liberacao_dtRetorno">
                        </div>
                        <div class="mb-3">
                            <label for="inputHora" class="form-label">Hora de Retorno</label>
                            <input type="time" class="form-control" id="inputHoraEntrada" name="liberacao_hrRetorno">
                        </div>
                        <div class="mb-3">
                            <label for="inputObservacoes" class="form-label">Descrição</label>
                            <textarea class="form-control" id="inputObservacoes" name="liberacao_observacao" placeholder="Descreva a liberação." required><?php echo $liberacao->liberacao_observacao; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
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
