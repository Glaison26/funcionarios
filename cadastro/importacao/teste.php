<?php
$string = '"Esta é uma string com aspas duplas"';
$nova_string = str_replace('"', '', $string);
echo $nova_string; // Saída: Esta é uma string com aspas duplas