<?php
include_once('../config/conexao.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-df5m027ofAKlfJ6rRhWBoNmXPTcIlDJFvL+OdSghjZtMiPMRZL7R02GqcfwbSzWl" crossorigin="anonymous">

<div class="container">
    <?php
    if (isset($_GET['msgType']) && isset($_GET['msg'])) {
        $msgType = $_GET['msgType'];
        $msg = $_GET['msg'];

        // Verificar o tipo de mensagem e exibir a mensagem correspondente
        if ($msgType === 'success') {
            echo '<div id="alert-container" class="alert alert-success alert-dismissible fade show" role="alert">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo urldecode($msg);
            echo '</div>';
        } elseif ($msgType === 'error') {
            echo '<div id="alert-container" class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo urldecode($msg);
            echo '</div>';
        }
    }
    ?>
    <script src="../operations/confirmAndSetId.js"></script>

    <div class="row justify-content-center gap-3">
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
                                            <td>
                                                <a href="home.php?sisco=editOcorrenciaMotivo&idOcorrenciaMotivo=<?php echo $ocMotivoId ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <form action="../operations/verifyOcorrenciaMotivo.php" method="post" id="formDestroyOcorrenciaMotivo" style="display: inline;">
                                                    <button class="btn btn-danger" name="removerOcorrenciaMotivo_<?php echo $ocMotivoId; ?>" type="button" onclick="confirmAndSetId('formDestroyOcorrenciaMotivo', 'id', <?php echo $ocMotivoId; ?>, 'esse motivo de ocorrência?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
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
                    <a href="home.php?sisco=cadOcorrenciaMotivo" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Novo Motivo Ocorrência</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Gerenciar Motivos de Eventos</h5>
                    <div class="table-responsive">
                        <table class="col-md-12 table">
                            <thead>
                                <th>Motivos Eventos</th>
                                <th class="text-center">Ações</th>
                            </thead>
                            <tbody>
                                <?php
                                $eventosMotivosQuery = "SELECT eventoMotivo_id, eventoMotivo_nome FROM tb_sisco_eventomotivo";

                                try {
                                    $stmtEventos = $conexao->prepare($eventosMotivosQuery);
                                    $stmtEventos->execute();
                                    $eventosMotivos = $stmtEventos->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($eventosMotivos as $eventoMotivo) {
                                        $eventoMotivoNome = $eventoMotivo['eventoMotivo_nome'];
                                        $eventoMotivoId = $eventoMotivo['eventoMotivo_id'];
                                ?>
                                        <tr>
                                            <td><?php echo $eventoMotivoNome; ?></td>
                                            <td>
                                                <a href="home.php?sisco=editEventoMotivo&idEventoMotivo=<?php echo $eventoMotivoId; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <form action="../operations/verifyEventoMotivo.php" method="post" id="formDestroyEventoMotivo" style="display: inline;">
                                                    <button class="btn btn-danger" type="button" onclick="confirmAndSetId('formDestroyEventoMotivo', 'idEventoMotivo', <?php echo $eventoMotivoId; ?>, 'esse motivo de evento');"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
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
                    <a href="home.php?sisco=cadEventoMotivo" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Novo Motivo de Evento</a>
                </div>
            </div>
        </div>
    </div>
</div>