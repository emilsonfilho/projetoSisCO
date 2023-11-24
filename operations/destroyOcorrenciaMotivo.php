<?php
include_once('../config/conexao.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$deleteOcorrencias = isset($_GET['deleteOcorrencias']) ? $_GET['deleteOcorrencias'] : false;

$queryDeleteMotivo = "DELETE FROM tb_sisco_ocorrenciamotivo WHERE ocorrenciaMotivo_id = :motivo_id";
$queryDeleteOcorrencias = "DELETE FROM tb_sisco_ocorrencia WHERE ocorrencia_idMotivo = :ocorrenciaMotivo_id";

try {
    if ($deleteOcorrencias) {
        $stmtDeleteOcorrencias = $conexao->prepare($queryDeleteOcorrencias);
        $stmtDeleteOcorrencias->bindValue(':ocorrenciaMotivo_id', $id, PDO::PARAM_INT);
        $stmtDeleteOcorrencias->execute();
    }

    $stmtDeleteMotivo = $conexao->prepare($queryDeleteMotivo);
    $stmtDeleteMotivo->bindValue(':motivo_id', $id, PDO::PARAM_INT);
    $stmtDeleteMotivo->execute();

    if ($stmtDeleteMotivo->rowCount() > 0) {
        $msgType = urlencode("success");
        // $msg = urlencode("Motivo de ocorrência deletado com sucesso!");
        $msg = urlencode($id);
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");    
    } else {
        $msgType = urlencode("error");
        $msg = urlencode("Erro ao excluir motivo de ocorrência.");
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
