<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include("../conexao.php");

if (!isset($_GET["id"])) {
    header('location: /funcionarios/cadastro/cadastro_lista.php');
    exit;
}
$c_id = "";
$c_id = $_GET["id"];

// Exclusão do registro
$c_sql = "delete from funcionarios where id=$c_id";
echo $c_sql;
echo $c_id;
$result = $conection->query($c_sql);

header('location: /funcionarios/cadastro/cadastro_lista.php');
