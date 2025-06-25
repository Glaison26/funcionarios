<?php
$dataString = "10/03/2024";
$timestamp = strtotime($dataString);

if ($timestamp !== false) {
  echo date("Y-m-d", $timestamp); // Saída: 10/03/2024 10:30:00
} else {
  echo "Formato de data inválido.";
}
?>