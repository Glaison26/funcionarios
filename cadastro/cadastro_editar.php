<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}


include('../conexao.php');
include('../links2.php');
include_once "../lib_gop.php";


// variaveis para mensagens de erro e suscessso da gravação
$msg_gravou = "";
$msg_erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {  // metodo get para carregar dados no formulário

    if (!isset($_GET["id"])) {
        header('location: /funcionarios/cadastro/cadastro_lista.php');
        exit;
    }

    $c_id = $_GET["id"];
    // leitura do cliente através de sql usando id passada
    $c_sql = "select * from funcionarios where id=$c_id";
    $result = $conection->query($c_sql);
    $registro = $result->fetch_assoc();

    if (!$registro) {
        header('location: /funcionarios/cadastro/cadastro_lista.php');
        exit;
    }
    $c_nome = $registro["nome"];
    $c_telefone = $registro['telefone'];
    $c_sexo = $registro['sexo'];
    $c_data = $registro['data_nasc'];
} else {
    // metodo post para atualizar dados
    $c_id = $_POST["id"];
    $c_nome = $_POST["nome"];
    $c_telefone = $_POST['telefone'];
    $c_sexo = $_POST['sexo'];
    $c_data = $_POST['data'];

    do {

        // faço a Leitura da tabela com sql
        $c_sql = "Update funcionarios" .
            " SET nome = '$c_nome', telefone ='$c_telefone', sexo ='$c_sexo', data_nasc='$c_data'" .
            " where id=$c_id";

        $result = $conection->query($c_sql);

        // verifico se a query foi correto
        if (!$result) {
            die("Erro ao Executar Sql!!" . $conection->connect_error);
        }
        $msg_gravou = "Dados Gravados com Sucesso!!";
        header('location: /funcionarios/cadastro/cadastro_lista.php');
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

</head>
<div class="container -my5">

    <body>
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>PMS - Cadastro de Funcionários</h4>
                    <h5>Editar dados do Funcionário<h5>
                </div>
            </div>
        </div>
         <div class='alert alert-info' role='alert'>
            <div style="padding-left:15px;">
                <img Align="left" src="\gop\images\escrita.png" alt="30" height="35">

            </div>
            <h5>Campos com (*) são obrigatórios</h5>
        </div>

        <hr>
        <?php
        if (!empty($msg_erro)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <div style='padding-left:15px;'>
                    
                </div>
                <h4><img Align='left' src='\gop\images\aviso.png' alt='30' height='35'> $msg_erro</h4>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $c_id; ?>">
        
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome (*)</label>
                <div class="col-sm-6">
                    <input type="text" maxlength="120" class="form-control" name="nome" value="<?php echo $c_nome; ?>" required>
                </div>
            </div>
            <?php
            $op1 = '';$op2 = '';
            if ($c_sexo == 'M') {
                $op1 = 'Selected';
            }
            if ($c_sexo == 'F') {
                $op2 = 'Selected';
            }
            
            ?>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Sexo (*)</label>
                <div class="col-sm-2">
                    <select class="form-select form-select-lg mb-3" id="sexo" name="sexo" required>
                        <option  <?php echo $op1 ?> value="M">Masculino</option>
                        <option  <?php echo $op2 ?> value="F">Feminino</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Telefone (*)</label>
                <div class="col-sm-3">
                    <input type="tel" placeholder="(99)9999-9999" onkeyup="handlePhone(event)" maxlength="40" class="form-control" name="telefone" value="<?php echo $c_telefone; ?>" required>
                </div>

            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Data de Nascimento (*)</label>
                <div class="col-sm-2">
                    <input type="date" maxlength="32" class="form-control" name="data" value="<?php echo $c_data; ?>" required>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="offset-sm-0 col-sm-3">
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                    <a class='btn btn-danger' href='/funcionarios/usuarios/usuarios_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                </div>

            </div>

        </form>
</div>

</body>

</html>