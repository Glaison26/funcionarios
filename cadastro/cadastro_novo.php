<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include('../conexao.php');
include('../links2.php');
include_once "../lib_gop.php";

$c_nome = "";
$c_telefone = "";
$c_sexo = "";
$c_data = "";


// variaveis para mensagens de erro e suscessso da gravação
$msg_gravou = "";
$msg_erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_nome = $_POST['nome'];
    $c_telefone = $_POST['telefone'];
    $c_sexo = $_POST['sexo'];
    $c_data = $_POST['data'];
    do {
        // faço a Leitura da tabela com sql
        $c_sql = "Insert into funcionarios (nome,telefone,sexo,data_nasc,status)" .
            "Value ('$c_nome', '$c_telefone', '$c_sexo', '$c_data','S')";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cpf").mask("999.999.999-99");
        });
    </script>

    <script>
        const handlePhone = (event) => {
            let input = event.target
            input.value = phoneMask(input.value)
        }

        const phoneMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "($1) $2")
            value = value.replace(/(\d)(\d{4})$/, "$1-$2")
            return value
        }
    </script>

</head>

<div class="container -my5">

    <body>
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>PMS - Cadastro de Funcionários</h4>
                    <h5>Novo Funcionário<h5>
                </div>
            </div>
        </div>
        <div class='alert alert-info' role='alert'>
            <div style="padding-left:15px;">
                <img Align="left" src="\funcionarios\imagens\escrita.png" alt="30" height="35">

            </div>
            <h5>Campos com (*) são obrigatórios</h5>
        </div>

        <?php
        if (!empty($msg_erro)) {
            echo '
            <div class="alert alert-warning" role="alert">
                <div style="padding-left:15px;">
                    
                </div>
                <h4><img Align="left" src="\funcionarios\imagens\aviso.png" alt="30" height="35"> $msg_erro</h4>
            </div>
            ';
        }
        ?>
        <form method="post">

            <hr>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome (*)</label>
                <div class="col-sm-6">
                    <input type="text" maxlength="120" class="form-control" name="nome" value="<?php echo $c_nome; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Sexo (*)</label>
                <div class="col-sm-2">
                    <select class="form-select form-select-lg mb-3" id="sexo" name="sexo" required>
                        <option></option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Telefone (*)</label>
                <div class="col-sm-3">
                    <input type="tel" placeholder="9999-9999" maxlength="40" class="form-control" name="telefone" value="<?php echo $c_telefone; ?>" required>
                </div>

            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Data de Nascimento (*)</label>
                <div class="col-sm-2">
                    <input type="date" maxlength="32" class="form-control" name="data" value="<?php echo $c_data; ?>" required>
                </div>
            </div>


            <?php
            if (!empty($msg_gravou)) {
                echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                             <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$msg_gravou</strong>

                             </div>
                        </div>     
                    </div>    
                ";
            }
            ?>
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