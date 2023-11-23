<?php
include_once('../config/conexao.php');

$id = $_GET['id'];
$deleteOcorrencias = isset($_GET['deleteOcorrencias']) ? $_GET['deleteOcorrencias'] : false;

$queryDeleteMotivo = "DELETE FROM tb_sisco_ocorrenciamotivo WHERE ocorrenciaMotivo_id = :id";
$queryDeleteOcorrencias = "DELETE FROM tb_sisco_ocorrencia WHERE ocorrencia_idMotivo = :id";

try {
    $conexao->beginTransaction();

    if ($deleteOcorrencias) {
        $stmtDeleteOcorrencias = $conexao->prepare($queryDeleteOcorrencias);
        $stmtDeleteOcorrencias->bindValue(':id', $id, PDO::PARAM_INT);
        $stmtDeleteOcorrencias->execute();
    }

    $stmtDeleteMotivo = $conexao->prepare($queryDeleteMotivo);
    $stmtDeleteMotivo->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtDeleteMotivo->execute();

    $conexao->commit();

    $msgType = urlencode("success");
    $msg = urlencode("Motivo de ocorrência deletado com sucesso!");
    header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
} catch (PDOException $e) {
    $conexao->rollBack();

    // Se ocorrer um erro durante o commit, ajuste a mensagem de erro
    $msgType = urlencode("error");
    $msg = urlencode("Erro ao excluir motivo de ocorrência: " . $e->getMessage());
    header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
}
?>
