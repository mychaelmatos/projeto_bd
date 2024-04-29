<?php

include 'class/class.consulta.php';

$consulta = new consultas();

$id_consulta = $_GET['id'];

$consulta->deleteConsulta($id_consulta);

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
