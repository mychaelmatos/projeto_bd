<?php

include 'class/class.tratamentos.php';
include 'class/class.consulta.php';
include 'class/class.medicamentos.php';
include 'class/class.prescricoes.php';
include 'class/class.fatura.php';

$medica = new Medicamentos();
$medicamento = $medica->getMedicamento();
$medicamentos = $medicamento->fetchAll(PDO::FETCH_ASSOC);

$fat = new fatura();
$consulta = new consultas();
$tratamento = new tratamentos();
$prescricao = new prescrisoes();

$id_consulta = $_GET['id'];

$query_fat = $fat->getFatura($id_consulta);
$result_fat = $query_fat->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $data_fim = $_POST['data_fim'];
    $valor = $_POST['valor'];

    $medicamento_input1 = (int)$_POST['medicamento1'];
    $quantidade1 = (int)$_POST['quantidade1'];
    $medicamento_input2 = (int)$_POST['medicamento2'];
    $quantidade2 = (int)$_POST['quantidade2'];
    $medicamento_input3 = (int)$_POST['medicamento3'];
    $quantidade3 = (int)$_POST['quantidade3'];
    $medicamento_input4 = (int)$_POST['medicamento4'];
    $quantidade4 = (int)$_POST['quantidade4'];
    $medicamento_input5 = (int)$_POST['medicamento5'];
    $quantidade5 = (int)$_POST['quantidade5'];

    
    $data_fim = $_POST['data_fim'];

    $tratamento->insertTratamento($id_consulta, $descricao, $data_fim, $valor);
    $prescricao->insertPrescricao($id_consulta,  $data_fim);

    $pres = $prescricao->getPrescricao($id_consulta);
    $prescricao_id = $pres->fetch(PDO::FETCH_ASSOC);
    $id_prescricao = $prescricao_id['id_prescricao'];


    $prescricao->insertPrescricaoAux($id_prescricao, $medicamento_input1, $quantidade1);
    if ($quantidade2 > 0) {
        $prescricao->insertPrescricaoAux($id_prescricao, $medicamento_input2, $quantidade2);
    }
    if ($quantidade3 > 0) {
        $prescricao->insertPrescricaoAux($id_prescricao, $medicamento_input3, $quantidade3);
    }
    if ($quantidade4 > 0) {
        $prescricao->insertPrescricaoAux($id_prescricao, $medicamento_input4, $quantidade4);
    }
    if ($quantidade5 > 0) {
        $prescricao->insertPrescricaoAux($id_prescricao, $medicamento_input5, $quantidade5);
    }

    $aux_new = $prescricao->getPrescricao($id_consulta);
    $new_id_prescricao = $aux_new->fetch(PDO::FETCH_ASSOC);
    $id_prescricao_new = $new_id_prescricao['id_prescricao'];

    $prescricao->ProcedimentoAtualizaFatura($result_fat['idFatura'], $id_prescricao_new);

    header('Location: medico.php');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescrição</title>
    <link rel="stylesheet" href="styles/prescricao.css">
</head>

<body>

    <header>
        <a href="index.php">Paciente</a>
        <a href="medico.php">Medico</a>
    </header>

    <h1>Prescrição Médica</h1>

    <form action="prescricao.php?id=<?= $id_consulta ?>" method="POST">

        <h3>Tratamento</h3>

        <label for="descricao">Descrição:</label>
        <input style="width: 800px; height: 100px;" type="text" name="descricao" id="descricao"><br><br>

        <label for="data_fim">Fim do Tratamento:</label>
        <input type="date" name="data_fim" id="data_fim"><br><br>

        <label for="valor">Valor:</label>
        <input type="number" name="valor" id="valor"><br><br>

        <h3>Medicamentos</h3>

        <div style="display: block;" class="escolher_medicamento" id="1">
            <select name="medicamento1" id="medicamento_id">
                <?php foreach ($medicamentos as $med) : ?>
                    <option value="<?= $med['id_medicamento'] ?>"><?= $med['nome'] . " -> Quantidade em estoque :" . $med['quantidade_estoque'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" placeholder="Quantidade" name="quantidade1" id="quantidade" min="1"><br><br>
        </div>

        <div style="display: none;" class="escolher_medicamento" id="2">
            <select name="medicamento2" id="medicamento_id">
                <?php foreach ($medicamentos as $med) : ?>
                    <option value="<?= $med['id_medicamento'] ?>"><?= $med['nome'] . " -> Quantidade em estoque :" . $med['quantidade_estoque'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" placeholder="Quantidade" name="quantidade2" id="quantidade" min="0"><br><br>
        </div>

        <div style="display: none;" class="escolher_medicamento" id="3">
            <select name="medicamento3" id="medicamento_id">
                <?php foreach ($medicamentos as $med) : ?>
                    <option value="<?= $med['id_medicamento'] ?>"><?= $med['nome'] . " -> Quantidade em estoque :" . $med['quantidade_estoque'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" placeholder="Quantidade" name="quantidade3" id="quantidade" min="0"><br><br>
        </div>

        <div style="display: none;" class="escolher_medicamento" id="4">
            <select name="medicamento4" id="medicamento_id">
                <?php foreach ($medicamentos as $med) : ?>
                    <option value="<?= $med['id_medicamento'] ?>"><?= $med['nome'] . " -> Quantidade em estoque :" . $med['quantidade_estoque'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" placeholder="Quantidade" name="quantidade4" id="quantidade" min="0"><br><br>
        </div>

        <div style="display: none;" class="escolher_medicamento" id="5">
            <select name="medicamento5" id="medicamento_id">
                <?php foreach ($medicamentos as $med) : ?>
                    <option value="<?= $med['id_medicamento'] ?>"><?= $med['nome'] . " -> Quantidade em estoque :" . $med['quantidade_estoque'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" placeholder="Quantidade" name="quantidade5" id="quantidade" min="0"><br><br>
        </div>
        
        <input type="button" id="botao_medicamento" value="Adicionar Medicamento"></input><br><br>

        <label for="data_fim">Medicar até a data:</label>
        <input type="date" name="data_fim" id="data_fim"><br><br>

        <button type="submit">Prescrever</button>
    </form>
</body>

<script>
    document.getElementById("botao_medicamento").addEventListener("click", function() {
        if(document.getElementById("2").style.display == "none") {
            document.getElementById("2").style.display = "block";
        } else if(document.getElementById("3").style.display == "none") {
            document.getElementById("3").style.display = "block";
        } else if(document.getElementById("4").style.display == "none") {
            document.getElementById("4").style.display = "block";
        } else if(document.getElementById("5").style.display == "none") {
            document.getElementById("5").style.display = "block";
            botao_medicamento.style.display = "none";
        }
});

</script>
</html>