<?php
$dataString = '24/04/1990';
$dataString = str_replace('/','-',$dataString);
$timestamp = strtotime($dataString);
echo 'time stamp' . $timestamp;
$d_data_aniv = date("Y-m-d", $timestamp);
echo 'd_data_aniv' . $d_data_aniv;
