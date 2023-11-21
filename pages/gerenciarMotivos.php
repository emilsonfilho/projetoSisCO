<?php
    include_once('../config/conexao.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-df5m027ofAKlfJ6rRhWBoNmXPTcIlDJFvL+OdSghjZtMiPMRZL7R02GqcfwbSzWl" crossorigin="anonymous">

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm rounded">
            <div class="card-body">
                <h5 class="card-title">Gerenciar Motivos de Ocorrências</h5>
                <div class="table-responsive">
                    <table class="col-md-12 table">
                        <thead>
                            <tr>
                                <th>Motivos Ocorrência</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ocMotivosQuery = "SELECT ocorrenciaMotivo_id, ocorrenciaMotivo_nome FROM tb_sisco_ocorrenciamotivo";

                                try {
                                    $stmtOcMotivos = $conexao->prepare($ocMotivosQuery);
                                    $stmtOcMotivos->execute();
                                    $ocMotivos = $stmtOcMotivos->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($ocMotivos as $ocMotivo) {
                                        $ocMotivoNome = $ocMotivo['ocorrenciaMotivo_nome'];
                                        $ocMotivoId = $ocMotivo['ocorrenciaMotivo_id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $ocMotivoNome ?></td>
                                                <td><a href="home.php?sisco=editOcorrenciaMotivo&idOcorrenciaMotivo=<?php echo $ocMotivoId ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a> <a href="" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                                            </tr>
                                        <?php
                                    }
                                } catch (PDOException $e) {
                                    echo "<b>Erro: </b>" . $e->getMessage();
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm rounded">
            <div class="card-body">
                <h5 class="card-title">Gerenciar Motivos de Eventos</h5>
                <div class="table-responsive">
                    <table class="col-md-12">
                        <thead>
                            <th>Motivos Eventos</th>
                            <th>Ações</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>