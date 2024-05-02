<?php

include 'class/class.fatura.php';

$fatura = new fatura();

$idFatrua = $_GET['id'];

$fatura->pagaFatura($idFatrua);

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
