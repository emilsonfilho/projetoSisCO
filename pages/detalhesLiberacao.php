<?php
include('../config/conexao.php');

// Verificar se o ID da liberação foi passado na URL
if (isset($_GET['idLiberacao'])) {
    $idLiberacao = $_GET['idLiberacao'];

    // Consulta SQL para obter os detalhes da liberação com base no ID
    $detalhesLiberacaoSelect = "SELECT tb_sisco_liberacao.liberacao_id AS id, tb_sisco_liberacao.liberacao_idDiscente, tb_sisco_liberacao.liberacao_idColaboradorSaida, tb_sisco_liberacao.liberacao_dtSaida, tb_sisco_liberacao.liberacao_hrSaida, tb_sisco_liberacao.liberacao_idColaboradorRetorno, tb_sisco_liberacao.liberacao_dtRetorno, tb_sisco_liberacao.liberacao_hrRetorno, tb_sisco_liberacao.liberacao_observacao, tb_jmf_discente.discente_nome AS nome_discente, tb_jmf_colaborador_saida.colaborador_nome AS nome_colaborador_saida, tb_jmf_colaborador_retorno.colaborador_nome AS nome_colaborador_retorno
               FROM tb_sisco_liberacao
               LEFT JOIN tb_jmf_discente ON tb_sisco_liberacao.liberacao_idDiscente = tb_jmf_discente.discente_matricula
               LEFT JOIN tb_jmf_colaborador AS tb_jmf_colaborador_saida ON tb_sisco_liberacao.liberacao_idColaboradorSaida = tb_jmf_colaborador_saida.colaborador_matricula
               LEFT JOIN tb_jmf_colaborador AS tb_jmf_colaborador_retorno ON tb_sisco_liberacao.liberacao_idColaboradorRetorno = tb_jmf_colaborador_retorno.colaborador_matricula
               WHERE tb_sisco_liberacao.liberacao_id = :idLiberacao";

    try {
        $stmtDetalhesLiberacao = $conexao->prepare($detalhesLiberacaoSelect);
        $stmtDetalhesLiberacao->bindValue(':idLiberacao', $idLiberacao);
        $stmtDetalhesLiberacao->execute();
        $detalhesLiberacao = $stmtDetalhesLiberacao->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<b>Erro: </b>" . $e->getMessage();
    }
} else {
    echo "ID da liberação não fornecido na URL.";
    exit;
}
?>

<script src="../operations/confirmDelete.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h6>Detalhes da Liberação</h6>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Discente:</th>
                        <td><?php echo $detalhesLiberacao['nome_discente']; ?></td>
                    </tr>
                    <tr>
                        <th>Colaborador Saída:</th>
                        <td><?php echo $detalhesLiberacao['nome_colaborador_saida']; ?></td>
                    </tr>
                    <tr>
                        <th>Data e Hora Saída:</th>
                        <td><?php echo date('d/m/Y', strtotime($detalhesLiberacao['liberacao_dtSaida'])) . ' - ' . date('H:i', strtotime($detalhesLiberacao['liberacao_hrSaida'])); ?></td>
                    </tr>
                    <tr>
                        <th>Colaborador Retorno:</th>
                        <td><?php echo $detalhesLiberacao['nome_colaborador_retorno'] ?? 'Não registrado'; ?></td>
                    </tr>
                    <?php if ($detalhesLiberacao['liberacao_idColaboradorRetorno']) { ?>
                        <tr>
                            <th>Data e Hora Retorno:</th>
                            <td><?php echo date('d/m/Y', strtotime($detalhesLiberacao['liberacao_dtRetorno'])) . ' - ' . date('H:i', strtotime($detalhesLiberacao['liberacao_hrRetorno'])); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Observação:</th>
                        <td><?php echo $detalhesLiberacao['liberacao_observacao'] ?? 'Não disponível'; ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
            <a href="home.php?sisco=editLiberacao&idLiberacao=<?php echo $idLiberacao; ?>" class="btn btn-primary">Editar Liberação</a>
            <form action="../operations/destroyLiberacao.php" method="post" id="formDestroyLiberacao" style="display: inline;">
                <input type="hidden" name="idLiberacao" value="<?php echo $detalhesLiberacao['id'] ?>">
                <button type="button" class="btn btn-danger" onclick="confirmarRemocao('essa liberação', '#formDestroyLiberacao')">Remover Liberação</button>
            </form>
        </div>
    </div>
</div>