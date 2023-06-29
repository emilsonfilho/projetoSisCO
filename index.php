<!--
===============================================================================
* Soft UI Dashboard - v1.0.7 - SAEP - Seleção de Alunos da Escola Profissional
===============================================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative
* Editado por Leandro Costa
=========================================================
-->
<?php
ob_start();
session_start();
if (isset($_SESSION['loginuser']) && (isset($_SESSION['senhauser'])) && (isset($_SESSION['nivel'])) /*&& ($_SESSION['nivel'] == 1)*/) {
    header("Location: pages/home.php?saep=painel");
    exit;
}
// elseif(isset($_SESSION['loginuser']) && (isset($_SESSION['senhauser'])) && (isset($_SESSION['nivel'])) && ($_SESSION['nivel'] != 1)){
//     header("Location: saepAdmin/pages/home.php?saep=painel");
//     exit;
// }
include('config/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    Login | Seleção de Alunos da Escola Profissional
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Sistema de Controle de Ocorrências</h3>
                  <p class="mb-0">Entre com seu E-mail e Senha cadastrado!</p>
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <label>E-mail</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" name="login">
                    </div>
                    <label>Senha</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" name="senha">
                    </div>
                    
                    <div class="text-center">
                      <button type="submit" name="loginSaep" class="btn bg-gradient-info w-100 mt-4 mb-0">Acessar sistema</button>
                    </div>
                  </form>
                </div>
                
              </div>
              <?php
                        //ACESSO NEGADO
                        if (isset($_GET['acao'])):
                            if (!isset($_POST['logar'])):
                                $acao = $_GET['acao'];
                                if ($acao == 'negado'):
                                    echo '<div class="alert alert-warning">
                                              <strong>Você não tem permissão de acesso!</strong> Efetue o login com credenciais cadastradas!
                                          </div>';
                                          header("Refresh: 3, index.php");
                                endif;
                            endif;
                        endif;

                        if (isset($_POST['loginSaep'])):
                            // $login = trim(strip_tags($_POST['login']));
                            // $senha = md5(trim(strip_tags($_POST['senha'])));
                            $login = $_POST['login'];
                            $senha = $_POST['senha'];



                            $select = "SELECT * FROM tb_jmf_colaborador WHERE BINARY colaborador_email=:email AND colaborador_senha=:senha";

                            try {
                                $result = $conexao->prepare($select);
                                $result->bindParam(':email', $login, PDO::PARAM_STR);
                                $result->bindParam(':senha', $senha, PDO::PARAM_STR);

                                $result->execute();

                                $contar = $result->rowCount();
                                $nivel = $result->fetch(PDO::FETCH_OBJ);


                                if ($contar > 0) {

                                    $_SESSION['loginuser'] = $login;
                                    $_SESSION['senhauser'] = $senha;
                                    
                                    /* Usadas no profile.php para mostrar dados do usuário logado */
                                    $_SESSION['nivel'] = intval($nivel->colaborador_idSetor);

                                    if ($_SESSION['nivel'] === 3) {
                                      echo '<div class="alert alert-success">
                                                <strong>Você será redirecionado(a) para o painel!</strong> Aguarde »»»
                                            </div>';

                                        header("Refresh: 3, pages/home.php?sisco=cadOcorrencia");
                                    } else {
                                      echo '<div class="alert alert-success">
                                                <strong>Você será redirecionado(a) para o painel!</strong> Aguarde »»»
                                            </div>';

                                        header("Refresh: 3, pages/home.php?sisco=corpoDoscente");
                                    }
                                } else {
                                    echo '<div class="alert alert-warning">'
                                    . 'Usuário ou senha incorreto'
                                    . '</div>';
                                    header("Refresh: 3, index.php");
                                }
                            } catch (PDOException $e) {
                                echo "<b>Erro: </b>" .$e->getMessage();
                            }
                        endif;
                        ?>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved-seduc.png')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Este é um software desenvolvido em parceria com alunos e professor da EEEP José Maria Falcão.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>