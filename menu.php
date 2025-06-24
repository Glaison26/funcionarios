<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession2'])) {
    die('Acesso não autorizado!!!');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>PMS - Cadastro de Funcionários</title>
</head>

<body>

    <div class="wrapper">

        <!-- Sidebar  -->
        <nav id="sidebar">

            <ul class="list-unstyled components">


                <li class="active">
                    <a href="#compras" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Cadastro</a>
                    <ul class="collapse list-unstyled" id="compras">
                        <li>
                            <a href="/pcas/consulta_previsoes.php"><img src="\funcionarios\imagens\pessoas.png" alt="" width="30" height="30"> Lista de Funcionários </a>
                        </li>
                        <li>
                            <a href="/pcas/importa_csv.php"><img src="\funcionarios\imagens\emitir.png" alt="" width="30" height="30"> Gerar Lista de envio</a>
                        </li>

                    </ul>
                </li>

                <li class="active">
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Usuários</a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li>
                            <a href="/funcionarios/usuarios/usuarios_lista.php"><img src="\funcionarios\imagens\usuario.png" alt="" width="30" height="30"> Cadastro de usuários</a>
                        </li>
                        <li>
                            <a href="/pcas/alterarsenha.php"><img src="\funcionarios\imagens\senha.png" alt="" width="30" height="30"> Alterar Senha</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/pcas/index.php"><img src="\funcionarios\imagens\saida.png" alt="" width="30" height="30"> Sair</a>
                </li>
            </ul>


        </nav>

        <!-- Page Content  -->
        <div id="content">

            <div class="card">
                <div class="card-header">

                    Usuário logado: <?php echo ' ' .$_SESSION['c_usuario'] . ' ' ?>

                </div>

            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <div class="panel default class" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
                <div class="panel-heading">
                    <img class="rounded mx-auto d-block" class="img-responsive" src="\funcionarios\imagens\prefeitura.jpeg" class="img-fluid" style="height :100px" style="width:110px">
                </div>
            </div>
        </div>
    </div>
    <div style="padding-bottom:15px;">
        <footer>
            <div style="padding-left :10px;">
                <p>
                <h5>Prefeitura Municipal de Sabará - Todos os direitos reservados</h5>
                </p>
            </div>
        </footer>
    </div>

</body>


</html>


<!-- rodape do menu -->
 <style>
     html,
     body {
         min-height: 100%;
     }

     body {
         padding: 0;
         margin: 0;
     }

     footer {
         position: fixed;
         bottom: 0;
         background-color: #4682B4;
         color: #FFF;
         width: 100%;
         height: 50px;
         text-align: left;
         line-height: 70px;
     }
 </style>