<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include("../../conexao.php");

$c_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Limpar o buffer de saída
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
        $c_tipo = $_POST['tipo'];
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
                        
            // verifico qual tipo da importação
            if ($c_tipo == "Aquisição") {  // rotina de importação por aquisição
                // Criar a QUERY para salvar o usuário no banco de dados
                $query = "INSERT INTO funcionarios (nome,telefone,sexo,data_nasc) VALUES (:objeto, :tipo, :natureza, :orgao_atendido, :data_conclusao, :em_andamento, :saldo_almorarifado, 
                :atavigente_renovacao, :previsao_qtd, :previsao_data, :previsao_valor_unit, :previsao_valor_total, :nivel_prioridade, :recursos_origem,
                :contratacoes, :estimativa)";

                // Preparar a QUERY
                $pca = $conn->prepare($query_pca);
                $c_nivel = "";
                // Substituir os links da QUERY pelos valores
                $pca->bindValue(':objeto', ($linha[2] ?? "NULL"));
                $pca->bindValue(':tipo', ('Aquisição' ?? "NULL"));
                $pca->bindValue(':natureza', ($linha[4] ?? "NULL"));
                $pca->bindValue(':orgao_atendido', ($linha[5] ?? "NULL"));
                //$c_data=;
                // formatação com mascara para datas do excell

                $d_dataconclusao = new DateTime(date('d/m/y', strtotime($linha[6])));
                $d_dataconclusao = $d_dataconclusao->format('Y-m-d');
                $pca->bindValue(':data_conclusao', ($d_dataconclusao ?? "NULL"));

                $pca->bindValue(':em_andamento', ($linha[7] ?? "NULL"));
                $pca->bindValue(':saldo_almorarifado', ($linha[8] ?? "NULL"));
                $pca->bindValue(':atavigente_renovacao', ($linha[9] ?? "NULL"));
                // formatação fiannceira do excell para o mysql
                $c_qtd = str_replace('.', '', $linha[10]);
                $c_qtd = str_replace(',', '.',  $c_qtd);
                $pca->bindValue(':previsao_qtd', ($c_qtd ?? "NULL"));

                // formatação com mascara para datas do excell
                $d_dataprevisao = new DateTime(date('d/m/y', strtotime($linha[11])));
                $d_dataprevisao = $d_dataprevisao->format('Y-m-d');
                $pca->bindValue(':previsao_data', ($d_dataprevisao ?? "NULL"));
                // formatação fiannceira do excell para o mysql
                $c_valorunit =  str_replace('R$', '', $linha[12]);
                $c_valorunit =  str_replace(".", '', $c_valorunit);
                $c_valorunit = str_replace(',', '.',  $c_valorunit);
                // formatação fiannceira do excell para o mysql
                $pca->bindValue(':previsao_valor_unit', ($c_valorunit ?? "NULL"));
                $c_valortotal = str_replace('R$', '', $linha[13]);
                $c_valortotal = str_replace('.', '',  $c_valortotal);
                $c_valortotal = str_replace(',', '.',  $c_valortotal);
                $pca->bindValue(':previsao_valor_total', ($c_valortotal ?? "NULL"));
                // verifica nivel de prioridade escolhido onde marcou letra X na coluna    
                if (($linha[14] == 'X') || ($linha[14] == 'x')) {
                    $c_nivel = '1';
                }
                if (($linha[15] == 'X') || ($linha[15] == 'x')) {
                    $c_nivel = '2';
                }
                if (($linha[16] == 'X') || ($linha[16] == 'x')) {
                    $c_nivel = '3';
                }
                $pca->bindValue(':nivel_prioridade', ($c_nivel ?? "NULL"));
                //
                $pca->bindValue(':estimativa', ($linha[17] ?? "NULL"));
                $pca->bindValue(':recursos_origem', ($linha[18] ?? "NULL"));
                $pca->bindValue(':contratacoes', ($linha[19] ?? "NULL"));
            }  // fim da rotina por aquisição

            // Executar a QUERY
            $pca->execute();

            // Verificar se cadastrou corretamente no banco de dados
            if ($pca->rowCount()) {
                $linhas_importadas++;
            } else {
                $linhas_nao_importadas++;
                $pca_nao_importado = $pca_nao_importado . ", " . ($linha[0] ?? "NULL");
            }
        }
        $c_msg = "Importação Fianalizada com sucesso!!";
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
                <a class="btn btn-danger" href="/pcas/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar ao menu</a>
            </div>
            <hr>
        </form>
    </div>

</body>

</html>