<?php

session_start();
include_once('../config/conexao.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$id = $_POST['idEventoMotivo'];

$queryCheckEventos = "SELECT COUNT(*) FROM tb_sisco_evento WHERE evento_idMotivo = :id";

try {
    $stmtCheck = $conexao->prepare($queryCheckEventos);
    $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtCheck->execute();

    $rowCount = $stmtCheck->fetchColumn();

    if ($rowCount > 0) {
        echo "<script>
                var userConfirmed = confirm('Existem eventos associados a este motivo. Deseja excluir os eventos junto com o motivo?');
                if (userConfirmed) {
                    window.location.href = 'destroyEventoMotivo.php?id=$id&deleteEventos=true';
                } else {
                    window.location.href = '../pages/home.php?sisco=gerenciarMotivos';
                }
              </script>";
    } else {
        // Se não houver ocorrências, prosseguir com a exclusão normalmente
        header("Location: destroyEventoMotivo.php?id=$id");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
