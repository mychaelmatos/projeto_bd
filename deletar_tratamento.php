<?php

include 'class\class.tratamentos.php';

$id_tratamento = $_GET['id'];

$tratamento_obj = new tratamentos();

$tratamento_obj->deleteTratamento($id_tratamento);

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;