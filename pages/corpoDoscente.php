<?php
include('../config/conexao.php');

$colaboradoresSelect = "SELECT tb_jmf_colaborador.colaborador_nome, tb_jmf_funcao.funcao_nome, tb_jmf_colaborador.colaborador_telefone
                        FROM tb_jmf_colaborador
                        INNER JOIN tb_jmf_funcao ON tb_jmf_colaborador.colaborador_idFuncao = tb_jmf_funcao.funcao_id";

try {
    $resultColaboradores = $conexao->prepare($colaboradoresSelect);
    $resultColaboradores->execute();

    $colaboradores = $resultColaboradores->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Corpo Docente</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Função</th>
                                <th>Telefone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colaboradores as $colaborador) : ?>
                                <tr>
                                    <td><?php echo $colaborador->colaborador_nome; ?></td>
                                    <td><?php echo $colaborador->funcao_nome; ?></td>
                                    <td><?php echo $colaborador->colaborador_telefone; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>