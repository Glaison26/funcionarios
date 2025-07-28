<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";
$c_sql = $_SESSION['sql'];

?>
<!doctype html>
<html lang="en">

<body>

    <script language="Javascript">
        function confirmacao(id) {
            var resposta = confirm("Deseja remover esse registro?");
            if (resposta == true) {
                window.location.href = "/funcionarios/cadastro/cadastro_excluir.php?id=" + id;
            }
        }
    </script>

    <script language="Javascript">
        function mensagem(msg) {
            alert(msg);
        }
    </script>


    <script>
        $(document).ready(function() {
            $('.tabfuncionarios').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [6]
                }, {
                    'aTargets': [0],
                    "visible": false
                }],
                "oLanguage": {
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                    "oPaginate": {
                        "spagingType": "full_number",
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",

                        "sLast": "Último"
                    },
                    "sSearch": "Pesquisar",
                    "sLengthMenu": 'Mostrar <select>' +
                        '<option value="5">5</option>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">Todos</option>' +
                        '</select> Registros'

                }

            });

        });
    </script>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>PMS - Cadastros de Funcionários da Aplicação</h4>
            <h5>Geração de Arquivo para envio<h5>
        </div>
    </div>
    <br>
    <div class="container-fluid">

        <a class='btn btn btn-sm' class="btn btn-primary" href='\funcionarios\cadastro\gerar_csv.php'><img src='\funcionarios\imagens\itabela.png' alt='' width='25' height='25'> Gerar Arquivo</a>
        <a class='btn btn btn-sm' class="btn btn-primary" href='\funcionarios\cadastro\telefonar.php'><img src='\funcionarios\imagens\telefone.png' alt='' width='25' height='25'> Telefonar</a>
        <a class="btn" href="/funcionarios/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>

        <hr>
        <table class="table table display table-active tabfuncionarios">
            <thead class="thead">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome do Funcionário</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Status</th>
                    <th scope="col">Alterar Status</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }

                // insiro os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                    $c_data_nasc = date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['data_nasc'])));
                    if ($c_linha['status'] == 'N')
                        $c_status = '<img src="\funcionarios\imagens\cancelar.png" alt="" width="25" height="25">';
                    else
                        $c_status = '<img src="\funcionarios\imagens\certo.png" alt="" width="25" height="25">';
                    echo "
                    <tr class='info'>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[nome]</td>
                    <td>$c_linha[telefone]</td>
                    <td>$c_linha[sexo_c]</td>
                    <td>$c_data_nasc</td>
                    <td style='text-align: center;'>$c_status</td>
                    <td>
                     <a class='btn btn-sm' href='/funcionarios/cadastro/resultado_selecionar.php?id=$c_linha[id]'><img src=".'\funcionarios\imagens\emitir.png'." alt=''
                      width='25' height='25'></a>
                   
                    </td>

                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>