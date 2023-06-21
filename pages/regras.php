<div class="container-fluid">
    <div class="page-header min-height-300 border-radius-xl" style="background-image: url('../../assets/img/curved-images/back-est.png'); background-position-y: 50%;">
    </div>
 
    <div class="row">
        <div class="col-lg-12">
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row" style="align-items: center;">
        <!-- Botão Modal -->
        <div class="col-lg-4">
          <a class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Cadastrar Regras do Edital
          </a>
        </div>
        <div class="col-lg-8"></div>
        <!-- Fim do Botão Modal -->
        
        <hr>
        <!-- Regra Cadastrada -->
        <div class="table-responsive p-0">
                <?php
                include('../../config/conexao.php');
                  if(isset($_POST['cadEdital'])){
                    
                    $qtd_aluno = $_POST['qtd_aluno'];
                    $aluno_publica = $_POST['aluno_publica'];
                    $aluno_particular = $_POST['aluno_particular'];
                    $com_laudo = $_POST['com_laudo'];
                    
                    //Query de banco de dados
                    $insert = "INSERT INTO tb_saep_edital (qtd_aluno,aluno_publica,aluno_particular,com_laudo) VALUES (:qAluno,:qPublica,:qParticular,:cLaudo)";

                    try {
                      //Preparar a conexão para fazer o insert
                    $result = $conexao->prepare($insert);
                    $result->bindParam(':qAluno',$qAluno,PDO::PARAM_INT);
                    $result->bindParam(':qPublica',$aluno_publica,PDO::PARAM_INT);
                    $result->bindParam(':qParticular',$aluno_particular,PDO::PARAM_INT);
                    $result->bindParam(':cLaudo',$com_laudo,PDO::PARAM_INT);
                    $result->execute();
                    //Resultado do cadastro
                    $contar = $result->rowCount();
                    if ($contar>0) {
                      echo '<div style="margin-top:10px" class="alert alert-success" role="alert">
                              Edital cadastrado com sucesso!!!
                            </div>';
                    header("Refresh: 3, home.php?saep=usuarios");
                    }else{
                      echo '<div style="margin-top:10px" class="alert alert-danger" role="alert">
                              Edital não cadastrado!!!
                            </div>';
                    }

                    } catch (PDOException $e) {
                      echo '<strong>ERRO DE CADASTRO = </strong>'.$e->getMessage();
                    }
                  }
                ?>
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">QTD Alunos por turma</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Escola Pública</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Escola Particular</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Com Laudo</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Ações</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex px-2">
                            <p class="text-sm font-weight-bold mb-0"  style="padding-left: 10px;">45</p>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0">36</p>
                      </td>
                      <td>
                      <p class="text-sm font-weight-bold mb-0">9</p>
                      </td>
                      <td class="align-middle text-center">
                      <p class="text-sm font-weight-bold mb-0">3</p>
                      </td>
                      <td class="align-middle text-center">
                        <button class="btn btn-success" title="Editar">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-danger" title="Deletar">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
        </div>
        </div>
        </div>
        <hr>

        
    </div>
    <!-- Incio do Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5 maius" id="exampleModalLabel">Cadastrar novo usuário</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <form action="" method="post">
                <div class="row">
                   
                        
                        <div class="mb-3">
                            <label>Quantidade de Alunos por Turma</label>
                            <input type="text" name="qtd_aluno" class="form-control" required>
                        </div>
                   
                        <div class="mb-3">
                            <label>Quant. Aluno de Esc. Pública</label>
                            <input type="text" name="aluno_publica" class="form-control" required>
                        </div>
                    
                        <div class="mb-3">
                            <label>Quant. Aluno de Esc. Particular</label>
                            <input type="text" name="aluno_particular" class="form-control" required>
                        </div>
                   
                        <div class="mb-3">
                            <label>Quant. Aluno com laudo médico</label>
                            <input type="text" name="com_laudo" class="form-control" required>
                        </div>
                    </div>
                </div>
                
                
           
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success" name="cadEdital">Inserir Regras do Edital</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Fim do Modal -->
    
    
    
</div>