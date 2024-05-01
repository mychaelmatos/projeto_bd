<?php

include 'class/class.paciente.php';
include 'class\class.medicos.php';
include 'class/class.consulta.php';
include 'class/class.tratamentos.php';
include 'class/class.prescricoes.php';

$id_consulta = $_GET['id'];

$consulta = new consultas();
$consultas = $consulta->getConsultaId($id_consulta);
$consultas = $consultas->fetch(PDO::FETCH_ASSOC);

$id_paciente = $consultas['id_paciente'];

$pacient = new paciente();
$paciente = $pacient->getPacienteId($id_paciente);
$pacientes = $paciente->fetch(PDO::FETCH_ASSOC);

$id_medico = $consultas['id_profissional'];

$medic = new medicos();
$medico = $medic->getMedicoId($id_medico);
$medicos = $medico->fetch(PDO::FETCH_ASSOC);

$tratamento = new tratamentos();
$tratamentos = $tratamento->getTratamentoId($id_consulta);
$tratamentos = $tratamentos->fetch(PDO::FETCH_ASSOC);

$prescricao = new prescrisoes();

$id_pres = $prescricao->getPrescricao($id_consulta);
$id_prescricao = $id_pres->fetch(PDO::FETCH_ASSOC)['id_prescricao'];

$prescricoes = $prescricao->getPrescricaoInfo($id_prescricao);
$prescricoes = $prescricoes->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles\informacao.css">
</head>

<body>

    <header>
        <a href="index.php">Paciente</a>
        <a href="medico.php">Medico</a>
    </header>

    <h1>Informações Gerais da Consulta</h1>
    <div class="cartao">
        <div class="div1">
            <h3>Informações da consulta</h3>
            <span>ID da consulta: </span>
            <?= $consultas['id_consulta'] ?><br><br>
            <span>Data da consulta: </span>
            <?= date('d/m/Y', strtotime($consultas['data_consulta'])) ?><br><br>
            <span>Motivo: </span>
            <?= $consultas['motivo'] ?><br><br>

            <h3>Informações do Paciente</h3>
            <span>Nome do paciente: </span>
            <?= $pacientes['primeiro_nome'] . " " . $pacientes['sobrenome'] ?><br><br>
            <span>Contato: </span>
            <?= $pacientes['telefone'] ?><br><br>
            <span>Endereço: </span>
            <?= $pacientes['endereco'] ?><br><br>
            <span>E-mail: </span>
            <?= $pacientes['email'] ?><br><br>
        </div>

        <div class="div3">
            <h3>Informações da Prescrição</h3>
            <span>Inicio: </span>
            <?= $prescricoes[0]['data_inicio'] ?><br><br>
            <span>Fim: </span>
            <?= $prescricoes[0]['data_fim'] ?><br><br>
            <?php foreach ($prescricoes as $p) : ?>
                <span>Medicamento: </span>
                <?= "" . $p['nome'] . "<br>" ?>
                <span>Quantidade: </span>
                <?= $p['quantidade'] ?><br><br>
            <?php endforeach; ?>
            <br><span>Valor total dos medicamentos: </span>
            <?= $prescricoes[0]['valor_prescricao'] ?><br><br>
        </div>

        <div class="div2">
            <h3>Informações do Médico</h3>
            <span>Nome do Médico: </span>
            <?= $medicos['primeiro_nome'] . " " . $medicos['sobrenome'] ?><br><br>
            <span>Especialidade: </span>
            <?= $medicos['especialidade'] ?><br><br>

            <h3>Informações do Tratamento</h3>
            <span>Descrição: </span>
            <?= $tratamentos['descricao'] ?><br><br>
            <span>Inicio: </span>
            <?= $tratamentos['data_inicio'] ?><br><br>
            <span>Fim: </span>
            <?= $tratamentos['data_fim'] ?><br><br>
            <span>Valor do tratamento: </span>
            <?= $tratamentos['valor_tratamento'] ?><br><br>
            <p><a style="border: 3px solid; padding: 3px;" href="deletar_tratamento.php?id=<?= $tratamentos['id_tratamento'] ?>">Deletar tratamento</a></p>
            <P><a style="border: 3px solid; padding: 3px;" href="finalizar_tratamento.php?id=<?= $tratamentos['id_tratamento'] ?>">Finalizar tratamento</a></P>
        </div>
    </div>
</body>

</html>