<?php

include 'class/class.consulta.php';
include 'class\class.medicos.php';

$id_consulta = $_GET['id'];

$consulta = new consultas();
$medic = new medicos();
$medico = $medic->getMedico();
$medicos = $medico->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medico = $_POST['medico'];

    $verific = $consulta->updateConsulta($id_consulta, $medico);

    if ($verific) {
        echo "<script>";
        echo "alert('Médico editado com sucesso.');";
        echo "window.location.replace('{$_SERVER['HTTP_REFERER']}');";
        echo "window.location.replace('medico.php');"; // Ir para medico.php após voltar
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('Tempo de 1 dia para editar médico já se passou.');";
        echo "window.location.replace('{$_SERVER['HTTP_REFERER']}');";
        echo "window.location.replace('medico.php');"; // Ir para medico.php após voltar
        echo "</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles\medico.css">
</head>

<body>
    <div class="tabelas">
        <form action="editar_consulta.php?id=<?= $id_consulta ?>" method="POST">
            <label for="medico">Medicos disponiveis:</label><br>
            <select name="medico" id="medico_id">
                <option disabled selected value="">Selecione um médico</option>
                <?php foreach ($medicos as $medi) { ?>
                    <option value="<?= $medi['numero_licenca']; ?>"><?= $medi['primeiro_nome'] . " " . $medi['sobrenome'] ?></option>
                <?php } ?>
            </select>
            <button type="submit">Mudar Médico</button>
        </form>
    </div>
</body>

</html>