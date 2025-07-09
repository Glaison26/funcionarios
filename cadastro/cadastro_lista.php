<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";

?>
<!doctype html>
<html lang="en">

<body>
   <!-- Script para exclusão do registro -->
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

   <!-- script jquery para tabela de funcionários -->
    <script>
        $(document).ready(function() {
            $('.tabfuncionarios').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [5]
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
            <h5>Lista de Funcionários<h5>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <a class="btn btn-success" href="/funcionarios/cadastro/cadastro_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary" href="/funcionarios/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
        <hr>
        <table class="table table display table-active tabfuncionarios">
            <thead class="thead">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome do Funcionário</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // faço a Leitura da tabela com sql
                $c_sql = "SELECT funcionarios.id, funcionarios.nome, funcionarios.telefone, funcionarios.sexo, funcionarios.data_nasc,
                case
                    when funcionarios.sexo='M' then 'Masculino'
                    when funcionarios.sexo='F' then 'Feminino'
                    END AS sexo_c FROM funcionarios
                ORDER BY funcionarios.nome";
                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }
                // insiro os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                    $c_data_nasc = date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['data_nasc'])));
                    echo "
                    <tr class='info'>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[nome]</td>
                    <td>$c_linha[telefone]</td>
                    <td>$c_linha[sexo_c]</td>
                    <td>$c_data_nasc</td>
                                     
                    <td>
                    <a class='btn' title='Editar registro' href='/funcionarios/cadastro/cadastro_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span></a>
                    <a class='btn' title='Excluir registro' href='javascript:func()'onclick='confirmacao($c_linha[id])'><span class='glyphicon glyphicon-trash'></span></a>
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