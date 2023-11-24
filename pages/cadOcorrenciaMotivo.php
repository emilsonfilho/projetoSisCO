<?php
include_once('../config/conexao.php');

$queryCategorias = "SELECT ocorrenciaCategoria_id, ocorrenciaCategoria_nome FROM tb_sisco_ocorrenciacategoria";

try {
    $stmtCategorias = $conexao->prepare($queryCategorias);
    $stmtCategorias->execute();

    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Criar Motivo de Ocorrência</h5>
                    <form action="../operations/postOcorrenciaMotivo.php" method="post">
                        <div class="mb-3">
                            <label for="inputNomeMotivo" class="form-label">Nome do motivo</label>
                            <input type="text" id="inputNomeMotivo" name="ocorrenciaMotivo_nome" class="form-control" placeholder="Informe o nome do motivo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao">Descrição do motivo</label>
                            <textarea name="ocorrenciaMotivo_descricao" id="descricao" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoria">Categoria do motivo</label>
                            <select name="ocorrenciaMotivo_idCategoria" id="categoria" class="form-select" required>
                                <?php
                                foreach ($categorias as $categoria) {
                                ?>
                                    <option value="<?php echo $categoria['ocorrenciaCategoria_id']; ?>"><?php echo $categoria['ocorrenciaCategoria_nome'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Enviar" class="btn btn-primary">
                            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>