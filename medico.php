<?php

include 'class/class.paciente.php';
include 'class\class.medicos.php';
include 'class/class.consulta.php';

$pacient = new paciente();
$paciente = $pacient->getPaciente();
$pacientes = $paciente->fetchAll(PDO::FETCH_ASSOC);

$medic = new medicos();
$medico = $medic->getMedico();
$medicos = $medico->fetchAll(PDO::FETCH_ASSOC);

$consulta = new consultas();
$consultas = $consulta->getConsulta();
$consultas = $consultas->fetchAll(PDO::FETCH_ASSOC);

$consulY = $consulta->getConsultaY();
$consultY = $consulY->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Medico</title>
    <link rel="stylesheet" href="styles\medico.css">
</head>

<body>

    <header>
        <a href="index.php">Paciente</a>
        <a href="medico.php">Médico</a>
    </header>

    <h1>Painel do Médico</h1>

    <div class="tabelas">
        <div class="tabela1">
            <h3>CONSULTAS AGENDADAS</h3>
            <table border="3px">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Data</th>
                        <th>Motivo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $consulta) : ?>
                        <tr>
                            <td><?= $consulta['nome_paciente'] ?></td>
                            <td><?= $consulta['nome_profissional'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($consulta['data_consulta'])) ?></td>
                            <td><?= $consulta['motivo'] ?></td>
                            <td><a class="botao_prescrever" href="prescricao.php?id=<?= $consulta['id_consulta']?>">Prescrever</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tabela2">
            <h3>CONSULTAS FEITAS</h3>
            <table border="3px">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Data</th>
                        <th>Motivo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultY as $consu) : ?>
                        <tr>
                            <td><?= $consu['nome_paciente'] ?></td>
                            <td><?= $consu['nome_profissional'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($consu['data_consulta'])) ?></td>
                            <td><?= $consu['motivo'] ?></td>
                            <td><a class="botao_prescrever" href="informacao.php?id=<?= $consu['id_consulta']?>">Informações</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>