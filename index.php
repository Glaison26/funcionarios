<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $l_erro = '';
} else {
    session_start();


    // conexão dom o banco de dados
    include("conexao.php");
    include("cabecalho.php");
    include("lib_gop.php");
    $c_login = $_POST['login'];
    $c_sql = "SELECT count(*) as achou FROM usuario where usuario.login='$c_login'";
    $result = $conection->query($c_sql);
    // verifico se a query foi correto
    if (!$result) {
        die("Erro ao Executar Sql !!" . $conection->connect_error);
    }
    $c_linha = $result->fetch_assoc();
    if ($c_login == 'xxx') {  // usuário e senha para entrar sem senha
        $_SESSION["newsession2"] = "user";
        $_SESSION['c_usuario'] = $c_login;
        $_SESSION['c_nome'] = $registro['nome']; // nome do usuário
        header('location: /funcionarios/menu.php');
    }
    if ($c_linha['achou'] == 0) {  // não achou usuário
        $l_erro = 'Falha no Login. Nome ou senha inválido. Verifique os dados e tente novamente !!!';
    } else {
        // procuro senha
        $c_sql = "SELECT usuarios.senha, usuarios.tipo, usuarios.nome, secretarias.descricao as secretaria, secretarias.id as id_secretaria 
        FROM usuarios JOIN secretarias ON secretarias.id=usuarios.id_secretaria where usuarios.login='$c_login'";
        $result = $conection->query($c_sql);
        $registro = $result->fetch_assoc();
        $c_senha = base64_decode($registro['senha']); // descriptografa senha
        if ($c_senha != $_POST['senha']) {  // não achou senha
            $l_erro = 'Falha no Login. Nome ou senha inválido. Verifique os dados e tente novamente !!!';
        } else {
            $l_erro = ' ';
            $_SESSION["newsession2"] = "user"; // passagem da segurança
            $_SESSION['c_usuario'] = $c_login; // login digitado
            $_SESSION['c_tipo'] = $registro['tipo']; // tipo do usuário
            $_SESSION['c_nome'] = $registro['nome']; // nome do usuário
            header('location: /funcionarios/menu.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PMS - Funcionários</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<div class="clearfix" style="display:none"></div>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>Acesso ao Sistema de Funcionários da Prefeitura</h4>
        </div>
    </div>


    <br>
    <?php
    if (!empty($l_erro)) {
        echo "
              <div class='alert alert-warning' role='alert'>
              <h4>$l_erro</h4>
              </div>
            ";
    }
    ?>
    <div class="container" style="width: 400px">

        <form method="post" class="row g-3">
            </br></br></br></br></br></br></br></br>
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h5>Dados para acesso </h5>
                </div>
            </div>

            <div class="well" style="width:400px">
                <div class="form-group row" class="form-control">
                    <label class="col-sm-3 col-form-label">Login</label>
                    <div class="col-xs-12">
                        <input type="text" maxlength="40" class="form-control" name="login" placeholder="Digite o login">
                    </div>
                </div>

                <div class="form-group row" class="form-control">
                    <label class="col-sm-3 col-form-label">Senha</label>
                    <div class="col-xs-12">
                        <input type="password" maxlength="32" class="form-control" name="senha" placeholder="Entre com a senha">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3">
                        <button name="btnentra" type="submit" class="btn btn-primary btn-sm"><span class='glyphicon glyphicon-log-in'></span> Fazer login</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>