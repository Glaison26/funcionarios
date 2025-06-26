
<?php
session_start();

//echo "<h1>Gerar Excel - csv</h1>";
// conexão dom o banco de dados
include("../conexao.php");
// Aceitar csv ou texto 
header('Content-Type: text/csv; charset=utf-8');

header('Content-Disposition: attachment; filename=vs_nm.csv');
// Gravar no buffer
$resultado = fopen("php://output", 'w');

//mb_convert_encoding('Endereço', "ISO-8859-1", "UTF-8")

// Criar o cabeçalho do Excel - Usar a função mb_convert_encoding para converter carateres especiais'
// faço a Leitura da tabela com sql


$c_sql = "SELECT   funcionarios.nome, funcionarios.telefone,  funcionarios.data_nasc, funcionarios.sexo
                
            WHERE (MONTH(data_nasc) > MONTH('$d_data1') OR (MONTH(data_nasc) = MONTH('$d_data1') AND DAY(data_nasc) >= DAY('$d_data1')))
            AND (MONTH(data_nasc) < MONTH('$d_data2') OR (MONTH(data_nasc) = MONTH('$d_data2') AND DAY(data_nasc) <= DAY('$d_data2')))
            ORDER BY MONTH(data_nasc), DAY(data_nasc)";
$result = $conection->query($c_sql);
//$cabecalho = [
//    'Inscrição',
//    'Nome',
//    'e-mail',
//    'cpf',
//    'rg',
//    'endereço',
//    'data Nascimento',
//    'telefone',
//    'Pós Curso Técnico',
//    'Graduação',
//    'Pós-Graduação',
//    'Experiência', 'data', 'hora'
//];

//$cabecalho = mb_convert_encoding($cabecalho, "ISO-8859-1", "UTF-8");
// Abrir o arquivo
$arquivo = fopen('file.csv', 'w');

// Escrever o cabeçalho no arquivo
fputcsv($resultado, $cabecalho, ';');
// verifico se a query foi correto
if (!$result) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}

// Array de dados
// insiro os registro do banco de dados na tabela 
while ($c_linha = $result->fetch_assoc()) {
    fputcsv($resultado, mb_convert_encoding($c_linha, "ISO-8859-1", "UTF-8"), ';');
}
// Fechar arquivo
fclose($resultado);
?>
