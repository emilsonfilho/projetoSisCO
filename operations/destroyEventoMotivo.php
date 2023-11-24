<?php
include_once('../config/conexao.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$deleteEventos = isset($_GET['deleteEventos']) ? $_GET['deleteEventos'] : false;

$queryDeleteMotivo = "DELETE FROM tb_sisco_eventomotivo WHERE eventoMotivo_id = :motivo_id";
$queryDeleteEventos = "DELETE FROM tb_sisco_evento WHERE evento_idMotivo = :ocorrenciamotivo_id";

try {
    $conexao->beginTransaction();

    if ($deleteEventos) {
        $stmtDeleteEventos = $conexao->prepare($queryDeleteEventos);
        $stmtDeleteEventos->bindValue(':ocorrenciamotivo_id', $id, PDO::PARAM_INT);
        $stmtDeleteEventos->execute();
    }

    $stmtDeleteMotivo = $conexao->prepare($queryDeleteMotivo);
    $stmtDeleteMotivo->bindValue(':motivo_id', $id, PDO::PARAM_INT);
    $stmtDeleteMotivo->execute();

    $conexao->commit();

    $msgType = urlencode("success");
    $msg = urlencode("Motivo de evento deletado com sucesso!");
    header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
} catch (PDOException $e) {
    $conexao->rollBack();

    // Se ocorrer um erro durante o commit, ajuste a mensagem de erro
    $msgType = urlencode("error");
    $msg = urlencode("Erro ao excluir motivo de evento: " . $e->getMessage());
    header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
}
?>
