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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo = $_POST['sexo'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $medico = $_POST['medico'];
    $motivo = $_POST['motivo'];

    $pacient->insertPaciente($nome, $sobrenome, $data_nascimento, $sexo, $endereco, $telefone, $email);
    $paciente = $pacient->getPacienteEmail($email);
    $pacientex = $paciente->fetch(PDO::FETCH_ASSOC);


    $consulta->insertConsulta($pacientex['id_paciente'], $medico, $motivo);
    
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="styles\style.css">
</head>

<body>

    <header>
        <a href="index.php">Paciente</a>
        <a href="medico.php">Medico</a>
    </header>

    <h1>Informações do Paciente</h1>

    <form action="index.php" method="POST">
        <div class="paginapaciente">
            <div class="paciente">
                <label for="nome">Nome:</label><br>
                <input type="text" id="nome_id" name="nome" required><br><br>

                <label for="sobrenome">Sobrenome:</label><br>
                <input type="text" id="sobrenome_id" name="sobrenome" required><br><br>

                <label for="data_nascimento">Data de Nascimento:</label><br>
                <input type="date" id="data_nascimento_id" name="data_nascimento" required><br><br>

                <label for="sexo">Sexo:</label><br>
                <input type="radio" id="masculino_id" name="sexo" value="M" required>
                <label for="masculino">Masculino</label>
                <input type="radio" id="feminino_id" name="sexo" value="F">
                <label for="feminino">Feminino</label><br><br>

                <label for="endereco">Endereço:</label><br>
                <input type="text" id="endereco_id" name="endereco" required><br><br>

                <label for="telefone">Telefone:</label><br>
                <input type="tel" id="telefone_id" name="telefone" required><br><br>

                <label for="email">Email:</label><br>
                <input type="text" id="email_id" name="email" required><br><br>
            </div>

            <div class="consulta">
                <label for="medico">Medicos disponiveis:</label><br>
                <select name="medico" id="medico_id">
                    <option disabled selected value="">Selecione um médico</option>
                    <?php foreach ($medicos as $medico) { ?>
                        <option value="<?= $medico['numero_licenca']; ?>"><?= $medico['primeiro_nome'] . " " . $medico['sobrenome']?></option>
                    <?php } ?>
                </select><br><br>

                <label for="motivo">Motivo da Consulta:</label><br>
                <input type="text" id="motivo_id" name="motivo" required><br><br>

                <input type="submit" value="Enviar">
            </div>
        </div>
    </form>
</body>

</html>