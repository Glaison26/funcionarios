<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include('../conexao.php');
include('../links2.php');
include_once "../lib_gop.php";
// monto sql com as datas
if ((isset($_POST["btnpesquisa"])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {

    // formatação de datas para o sql
    $d_data1 = $_POST['data1'];
    $d_data1 = date("Y-m-d", strtotime(str_replace('/', '-', $d_data1)));
    $d_data2 = $_POST['data2'];
    $d_data2 = date("Y-m-d", strtotime(str_replace('/', '-', $d_data2)));
    // expressão sql inicia para recursos fisicos

    // montagem do sql para recursos físicos
    $c_sql = "SELECT  funcionarios.id, funcionarios.nome, funcionarios.telefone, funcionarios.sexo, funcionarios.data_nasc, funcionarios.status,
                case
                    when funcionarios.sexo='M' then 'Masculino'
                    when funcionarios.sexo='F' then 'Feminino'
                    END AS sexo_c FROM funcionarios
            WHERE (MONTH(data_nasc) > MONTH('$d_data1') OR (MONTH(data_nasc) = MONTH('$d_data1') AND DAY(data_nasc) >= DAY('$d_data1')))
            AND (MONTH(data_nasc) < MONTH('$d_data2') OR (MONTH(data_nasc) = MONTH('$d_data2') AND DAY(data_nasc) <= DAY('$d_data2')))
            ORDER BY MONTH(data_nasc), DAY(data_nasc)";
    // chamo pagina com os dados a serem selecionados passando a string sql
    $_SESSION['sql'] = $c_sql;
    $_SESSION['c_data1']=$d_data1;
    $_SESSION['c_data2']=$d_data2;
    //echo $c_sql;
    header('location: /funcionarios/cadastro/resultado_lista.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>


<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>PMS - Controle de Funcionários</h4>
            <h5>Geração de Resultado<h5>
        </div>
    </div>
    <div class="content">

        <div class="container -my5">
            <div class='alert alert-info' role='alert'>
                <div style="padding-left:15px;">
                    <img Align="left" src="\gop\images\escrita.png" alt="30" height="35">

                </div>
                <h5>Selecione o período para resultado de envio</h5>
            </div>
            <form method="post">
                <div style="padding-top:5px;padding-bottom:5px">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <button type="submit" name='btnpesquisa' id='btnpesquisa' class="btn btn btn-sm"><img src="\gop\images\lupa.png" alt="" width="20" height="20"></span> Pesquisar</button>
                            <!--<a class="btn btn btn-sm" href="#"><img src="\gop\images\eraser.png" alt="" width="25" height="25"> Limpar pesquisa</a> -->
                            <a class="btn btn btn-sm" href="\funcionarios\menu.php"><img src="\gop\images\saida.png" alt="" width="25" height="25"> Voltar</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-light class">
                    <div class="panel-heading text-center">
                        <h5>Opções de Consulta<h5>
                    </div>
                </div>


                <br>
                <div class="row mb-3">

                    <label class="col-md-2 form-label">De</label>
                    <div class="col-sm-3">
                        <input type="Date" class="form-control" name="data1" id="data1" value='<?php echo date("Y-m-d"); ?>' onkeypress="mascaraData(this)">
                    </div>
                    <label class="col-md-1 form-label">até</label>
                    <div class="col-sm-3">
                        <input type="Date" class="form-control" name="data2" id="data2" value='<?php echo date("Y-m-d"); ?>' onkeypress="mascaraData(this)">
                    </div>
                </div>
            </form>
        </div>
    </div>



</body>

</html>