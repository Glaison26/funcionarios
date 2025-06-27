<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include('../conexao.php');
if (!isset($_GET["id"])) {
    header('location: /funcionarios/cadastro/resultado_lista.php');
    exit;
}
$c_id = "";
$c_id = $_GET["id"];
// verifico status para ser aletrado
$c_sql = "select funcionarios.status from funcionarios where id=$c_id";
$result = $conection->query($c_sql);
$c_linha = $result->fetch_assoc();
if ($c_linha['status']=='S')
  $c_status='N';
else
  $c_status='S';
// alteração do campo de geração de registro da preventiva
$c_sql = "update funcionarios set status='$c_status' where id=$c_id";
$result = $conection->query($c_sql);
header('location: /funcionarios/cadastro/resultado_lista.php');