<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include('../../conexao.php');
 $i_progresso = 0;
// rotina para entrada do usuário
$c_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Limpar o buffer de saída
    ob_start();

    // Receber o arquivo do formulário
    $arquivo = $_FILES['arquivo'];
    //var_dump($arquivo);

    // Variáveis de validação
    $linha_cabecalho = 1;
    $linhas_importadas = 0;
    $linhas_nao_importadas = 0;
    $pca_nao_importado = "";
   

    // Verificar se é arquivo csv
    if (($arquivo['type'] == "text/csv") && ($c_msg == "")) {

        $i_cabec = 2;

        // Ler os dados do arquivo
        $dados_arquivo = fopen($arquivo['tmp_name'], "r");
        $c_msg = "Importação não completada";
        
        // Percorrer os dados do arquivo
        while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {
            // Como ignorar a primeira linha do Excel

            if ($linha_cabecalho < $i_cabec) {
                $linha_cabecalho++;
                continue;
            }
            if ($linha[2] == '') {
                continue;
            }

            array_walk_recursive($linha, 'converter');
            //var_dump($linha);
            // Substituir os links da QUERY pelos valores
            $c_nome = $linha[2];
            $c_telefone = $linha[4];
            $c_telefone = str_replace('1)', '', $c_telefone);
            $c_telefone = str_replace('-', '', $c_telefone);
            if (strlen(rtrim($c_telefone)) < 9)
                $c_telefone = '9' . $c_telefone;
            if (strlen(rtrim($c_telefone)) < 9)
                $c_telefone = '';
            $c_sexo = substr($linha[1], 0, 1);
            $dataString = $linha[3];
            $dataString = $dataString = str_replace('/', '-', $dataString);
            $timestamp = strtotime($dataString);
            $d_data_aniv = date("Y-m-d", $timestamp);
            // Criar a QUERY para salvar o funcionario no banco de dados
            $query = "INSERT INTO funcionarios (nome,telefone,sexo,data_nasc,status)
                VALUES ('$c_nome','$c_telefone', '$c_sexo', '$d_data_aniv','S')";

            $result = $conection->query($query);
            $i_progresso++;
            // formatação com mascara para datas do excell
        }
        $c_msg = "Importação Finalizada com sucesso!!";
    }
}

// Criar função valor por referência, isto é, quando alter o valor dentro da função, vale para a variável fora da função.
function converter(&$dados_arquivo)
{
    // Converter dados de ISO-8859-1 para UTF-8
    $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PMS - Importação de Dados</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>PMS - Cadastro de Funcionários</h4>
            <h5>Importar dados para banco de Funcionários<h5>
        </div>

    </div>
    <br>
    <div class="container">
        <?php
        if (!empty($c_msg)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <h4>$c_msg</h4>
            </div>
                ";
        }
         echo "<div class='alert alert-success'>
                <strong>Progresso: $i_progresso </strong>
            </div>";
        ?>
        <!-- Formulario para enviar arquivo .csv -->
        <form method="post" enctype="multipart/form-data">
            <div class="alert alert-success">
                <strong>Selecione arquivo para importação!!! </strong>
            </div>
           
            <label>Arquivo: </label>
            <input type="file" name="arquivo" accept="text/csv"><br><br>

            <hr>
            <div class="container-fluid" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="left">
                <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-open-file'></span> Importar Arquivo</button>
                <a class="btn btn-danger" href="/funcionarios/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar ao menu</a>
            </div>
            <hr>
        </form>
    </div>

</body>

</html>