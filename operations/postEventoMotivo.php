<?php
session_start();
include('../config/conexao.php');
require_once('../utils/agora.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$eventoMotivo_nome = $_POST['eventoMotivo_nome'];
$eventoMotivo_descricao = $_POST['eventoMotivo_descricao'];
$eventoMotivo_idCategoria = $_POST['eventoMotivo_idCategoria'];

$query = "INSERT INTO tb_sisco_eventomotivo (
    eventoMotivo_idCategoria,
    eventoMotivo_nome,
    eventoMotivo_descricao
) VALUES (
    :idCategoria,
    :nome,
    :descricao
)";

try {
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(':idCategoria', $eventoMotivo_idCategoria);
    $stmt->bindValue(':nome', $eventoMotivo_nome);
    $stmt->bindValue(':descricao', $eventoMotivo_descricao);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $msgType = urlencode("success");
        $msg = urlencode("Motivo de evento registrado com sucesso!");
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
    } else {
        $msgType = urlencode("error");
        $msg = urlencode("Ocorreu algum erro ao tentar registrar o motivo de evento.");
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}