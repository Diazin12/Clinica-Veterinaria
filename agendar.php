<?php
require_once 'includes/cabecalho.php';
require_once 'dados/consultas.php';

$hoje        = "2026-10-15";      // data simulada
$veterinario = "Dra.Brinquedos";  // única veterinária da clínica

// Os nomes dentro de $_POST[""] precisam ser iguais aos name dos inputs do formulário
$pet     = htmlspecialchars($_POST["pet"] ?? "");
$tutor   = htmlspecialchars($_POST["tutor"] ?? "");
$servico = htmlspecialchars($_POST["servico"] ?? "");
$data    = htmlspecialchars($_POST["data"] ?? "");
$hora    = htmlspecialchars($_POST["hora"] ?? "");
$status  = "agendado"; // todo agendamento novo começa como agendado

$erro = "";

if ($pet === "" || $tutor === "" || $servico === "" || $data === "" || $hora === "") {
    $erro = "Preencha todos os campos.";
} elseif ($data < $hoje) {
    $erro = "A data não pode estar no passado.";
} elseif ($hora < "08:00" || $hora > "18:00") {
    $erro = "Atendimento apenas das 08:00 às 18:00.";
} else {
    foreach ($consultas as $c) {
        if ($c["veterinario"] === $veterinario && $c["data"] === $data && $c["hora"] === $hora && $c["status"] !== "cancelado") {
            $erro = "Esse horário já está ocupado.";
            break;
        }
    }
}
?>

<?php if ($erro !== ""): ?>
    <p style="color:red;"><?= $erro ?></p>
<?php else: ?>
    <p><?= $hora ?> <?= $tutor ?> <?= $pet ?> <?= $servico ?> <?= $status ?></p>
<?php endif; ?>

<?php require_once 'includes/rodape.php'; ?>
