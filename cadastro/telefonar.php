<?php
$pythonScript = '/caminho/para/seu/script.py'; // caminho da aplicação pytohon
$output = array();
$return_var = 0;

exec("python3 " . escapeshellarg($pythonScript), $output, $return_var);

if ($return_var === 0) {
    echo "Aplicativo de discagem executado com sucesso.<br>";
    foreach ($output as $line) {
        echo $line . "<br>";
    }
} else {
    echo "Erro ao executar o aplicativo de discagem.<br>";
    foreach ($output as $line) {
        echo $line . "<br>";
    }
}
?>