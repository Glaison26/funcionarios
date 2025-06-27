<?php
session_start();
$d_data1=$_SESSION['c_data1'];
$d_data2=$_SESSION['c_data2'];
// conexão dom o banco de dados
include("../conexao.php");
// Aceitar csv ou texto 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=contatos.csv');
// Gravar no buffer
//$resultado = fopen("php://output", 'w');
//$caminho_pasta = '/laragon/www/funcionarios/docs/';
$caminho_pasta = '/docs/envios/';
$resultado = 'contatos.csv';
$resultado = $caminho_pasta.$resultado;
$resultado = fopen($resultado, 'w');

//mb_convert_encoding('Endereço', "ISO-8859-1", "UTF-8")

// Criar o cabeçalho do Excel - Usar a função mb_convert_encoding para converter carateres especiais'
// faço a Leitura da tabela com sql
$c_sql = "SELECT funcionarios.nome, funcionarios.telefone,  funcionarios.data_nasc, funcionarios.sexo FROM funcionarios
            WHERE (status<>'N') and (MONTH(data_nasc) > MONTH('$d_data1') OR (MONTH(data_nasc) = MONTH('$d_data1') AND DAY(data_nasc) >= DAY('$d_data1')))
            AND (MONTH(data_nasc) < MONTH('$d_data2') OR (MONTH(data_nasc) = MONTH('$d_data2') AND DAY(data_nasc) <= DAY('$d_data2')))
            ORDER BY MONTH(data_nasc), DAY(data_nasc)";
            //echo $c_sql;
$result = $conection->query($c_sql);
$cabecalho = [
    'Nome',
    'Telefone',
    'Data Nascimento',
    'Sexo'
];


// verifico se a query foi correto
if (!$result) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}

// Array de dados
// insiro os registro do banco de dados na tabela 
while ($c_linha2 = $result->fetch_assoc()) {
    $c_linha2 = str_replace('(31)','',$c_linha2);
    fputcsv($resultado, $c_linha2, ';');
}
// Fechar arquivo
fclose($resultado);
?>
