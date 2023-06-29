<?php
session_start();
include('../config/conexao.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$emailLogado = $_SESSION['loginuser'];

$consultaIdPessoa = "SELECT colaborador_matricula FROM tb_jmf_colaborador WHERE colaborador_email = :email";

try {
    $stmt = $conexao->prepare($consultaIdPessoa);
    $stmt->bindValue(':email', $emailLogado);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        echo "E-mail não encontrado no banco de dados";
        exit;
    }

    $idColaborador = $row['colaborador_matricula'];
} catch (PDOException $e) {
    echo "<strong>Error:</strong>" . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evento_idDiscente = $_POST['discente_matricula'];
    $evento_idColaborador = $idColaborador;

    // Esse select teve que ficar aqui porque ele depende de um valor que é o id do discente
    $selectResponsavelLegal = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavelLegal = $conexao->prepare($selectResponsavelLegal);
        $stmtResponsavelLegal->bindValue(':matricula', $evento_idDiscente);
        $stmtResponsavelLegal->execute();
        $rowResponsavelLegal = $stmtResponsavelLegal->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavelLegal === false) {
            echo "Responsável legal não encontrado no banco de dados";
            exit;
        }

        $evento_idResponsavelLegal = $rowResponsavelLegal['discente_idResponsavel'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    // Outro select para pegar a categoria correspondente
    $evento_idMotivo = $_POST['evento_idMotivo'];

    $selectCategoria = "SELECT eventoMotivo_idCategoria FROM tb_sisco_eventomotivo WHERE eventoMotivo_id = :idMotivo";

    try {
        $stmtCategoria = $conexao->prepare($selectCategoria);
        $stmtCategoria->bindValue(':idMotivo', $evento_idMotivo);
        $stmtCategoria->execute();
        $rowCategoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        if ($rowCategoria === false) {
            echo "Categoria não encontrada no banco de dados";
            exit;
        }

        $evento_idCategoria = $rowCategoria['eventoMotivo_idCategoria'];
        var_dump($evento_idCategoria);
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $evento_data = $_POST['evento_data'];
    $evento_hora = $_POST['evento_hora'];
    $evento_descricao = $_POST['evento_observacao'];
    $evento_dataTime = date('Y-m-d H:i:s');

    try {
        // Preparar a consulta SQL para inserir os dados na tabela de ocorrências
        $inserirevento = "INSERT INTO tb_sisco_evento (evento_idDiscente, evento_idColaborador, evento_idResponsavel, evento_idCategoria, evento_idMotivo, evento_data, evento_hora, evento_observacao, evento_dateTime)
                              VALUES (:idDiscente, :idColaborador, :idResponsavelLegal, :idCategoria, :idMotivo, :data, :hora, :descricao, :dataTime)";

        // Preparar a declaração
        $stmtInserirevento = $conexao->prepare($inserirevento);

        // Vincular os valores aos parâmetros da consulta
        $stmtInserirevento->bindValue(':idDiscente', $evento_idDiscente);
        $stmtInserirevento->bindValue(':idColaborador', $evento_idColaborador);
        $stmtInserirevento->bindValue(':idResponsavelLegal', $evento_idResponsavelLegal);
        $stmtInserirevento->bindValue(':idMotivo', $evento_idMotivo);
        $stmtInserirevento->bindValue(':idCategoria', $evento_idCategoria);
        $stmtInserirevento->bindValue(':data', $evento_data);
        $stmtInserirevento->bindValue(':hora', $evento_hora);
        $stmtInserirevento->bindValue(':descricao', $evento_descricao);
        $stmtInserirevento->bindValue(':dataTime', $evento_dataTime);

        // Executar a consulta
        $stmtInserirevento->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($stmtInserirevento->rowCount() > 0) {
            echo "Evento registrado com sucesso!";
        } else {
            echo "Ocorreu um erro ao registrar o evento.";
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong> " . $e->getMessage();
    }
}
