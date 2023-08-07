
<?php


    $liberacao_data = $_POST['liberacao_dtSaida'];
    $liberacao_hora = $_POST['liberacao_hrSaida'];
    $liberacao_observacao = $_POST['liberacao_observacao'];
    $liberacao_dateTime = date('Y-m-d H:i:s');

    try {
        // Preparar a consulta SQL para inserir os dados na tabela de ocorrências
        $inserirliberacao = "INSERT INTO tb_sisco_liberacao (liberacao_idDiscente, liberacao_idColaboradorSaida, liberacao_idResponsavel, liberacao_dtSaida, liberacao_hrSaida, liberacao_observacao, liberacao_dateTime)
                              VALUES (:idDiscente, :idColaboradorSaida, :idResponsavel, :dtSaida, :hrSaida, :observacao, :dateTime)";

        // Preparar a declaração
        $stmtInserirliberacao = $conexao->prepare($inserirliberacao);

        // Vincular os valores aos parâmetros da consulta
        $stmtInserirliberacao->bindValue(':idDiscente', $liberacao_idDiscente);
        $stmtInserirliberacao->bindValue(':idColaboradorSaida', $liberacao_idColaborador);
        $stmtInserirliberacao->bindValue(':idResponsavel', $liberacao_idResponsavel);
        $stmtInserirliberacao->bindValue(':dtSaida', $liberacao_data);
        $stmtInserirliberacao->bindValue(':hrSaida', $liberacao_hora);
        $stmtInserirliberacao->bindValue(':observacao', $liberacao_observacao);
        $stmtInserirliberacao->bindValue(':dateTime', $liberacao_dateTime);

        // Executar a consulta
        $stmtInserirliberacao->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($stmtInserirliberacao->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Liberação registrada com sucesso.");
            header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        } else {
            echo "Ocorreu um erro ao registrar a liberação.";
        }
    } catch (PDOException $e) {
        // echo "<strong>Error:</strong> " . $e->getMessage();
        $msgType = urlencode("error");
    $msg = urlencode("Ocorreu algum erro ao tentar registrar a liberção.");
    header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
    }
}

`

Tenho esse carinha aqui e tenho esse formulário

` 

// Consulta SQL para obter as liberações com paginação
$liberacoesSelect = "SELECT tb_sisco_liberacao.liberacao_id, tb_sisco_liberacao.liberacao_dtSaida, tb_sisco_liberacao.liberacao_hrSaida, tb_jmf_colaborador.colaborador_nome, tb_sisco_liberacao.liberacao_observacao, tb_sisco_liberacao.liberacao_idDiscente
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
                                        <input class="form-check-input" type="radio" name="tipoLiberacao" id="inputEntrada" value="entrada" required>
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
                                    <input type="date" class="form-control" id="inputDataEntrada" name="liberacao_dtSaida" required value="<?php echo date("Y-m-d") ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputHora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="inputHoraEntrada" name="liberacao_hrSaida" value="<?php echo date("H:i") ?>" required>
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
</script>`

Assim: dependendo do tipo de input marcado, a data e a hora vai ser inserida no banco com um canto diferente. Exemplo, se está marcado como entrada, data e hora vai entrar em liberacao_dtRetorno e liberacao_hrRetorno. Agora: digamos que ele venha com saida, vai ir para liberacao_dtSaida e liberacao_hrSaida