<?php
include('../config/conexao.php');

if (isset($_SESSION['nivel'])) {
    if ($_SESSION['nivel'] !== 3) {
        $msgType = urlencode('error');
        $msg = urlencode('Você não tem acesso à página de cadastro de eventos.');
        header("Location: home.php?sisco=corpoDoscente&msgType=$msgType&msg=$msg");
    }
}

$discentesSelect = "SELECT tb_jmf_discente.*, tb_jmf_turma.turma_serie, tb_jmf_turma.turma_nome
           FROM tb_jmf_discente
           JOIN tb_jmf_turma ON tb_jmf_discente.discente_idTurma = tb_jmf_turma.turma_id
           WHERE tb_jmf_turma.turma_ano >= " . (date("Y") - 2) . "
           ORDER BY tb_jmf_discente.discente_nome ASC";

$motivosSelect = "SELECT eventoMotivo_id, eventoMotivo_nome FROM tb_sisco_eventomotivo";


try {
    $resultDiscentes = $conexao->prepare($discentesSelect);
    $resultDiscentes->execute();

    $discentes = $resultDiscentes->fetchAll(PDO::FETCH_OBJ);

    $motivos = $conexao->query($motivosSelect)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // echo "<b>Erro: </b>" . $e->getMessage();
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo 'Ocorreu um erro ao tentar carregar a página.';
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de Eventos</h5>
                    <form method="POST" action="../operations/postEvento.php">
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
                                    <label for="inputData" class="form-label">Data</label>
                                    <input type="date" class="form-control" id="inputData" name="evento_data" required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputHora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="inputHora" name="evento_hora" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="inputMotivo" class="form-label">Motivo</label>
                                    <?php foreach ($motivos as $motivo) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="evento_idMotivo" id="inputMotivo<?php echo $motivo['eventoMotivo_id']; ?>" value="<?php echo $motivo['eventoMotivo_id']; ?>" required>
                                            <label class="form-check-label" for="inputMotivo<?php echo $motivo['eventoMotivo_id']; ?>">
                                                <?php echo $motivo['eventoMotivo_nome']; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="inputObservacoes" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="inputObservacoes" name="evento_observacao" placeholder="Descreva o evento." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
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