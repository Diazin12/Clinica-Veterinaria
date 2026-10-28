<?php
require_once 'dados/consultas.php';
require_once 'includes/cabecalho.php';

$hoje        = date('Y-m-d');
$veterinario = "Dra.Brinquedos";

$pet     = trim((string) ($_POST["pet"] ?? ""));
$tutor   = trim((string) ($_POST["tutor"] ?? ""));
$servico = trim((string) ($_POST["servico"] ?? ""));
$data    = trim((string) ($_POST["data"] ?? ""));
$hora    = trim((string) ($_POST["hora"] ?? ""));
$status  = "agendado";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $erro = "Preencha o formulário de agendamento.";
} elseif ($pet === "" || $tutor === "" || $servico === "" || $data === "" || $hora === "") {
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

if ($erro === "") {
    $proximoId = (count($consultas) ? max(array_column($consultas, "id")) : 0) + 1;
    $consultas[] = [
        "id" => $proximoId,
        "pet" => $pet,
        "tutor" => $tutor,
        "servico" => $servico,
        "veterinario" => $veterinario,
        "data" => $data,
        "hora" => $hora,
        "status" => $status,
    ];
    $sucesso = "Agendamento realizado com sucesso.";
}

$mostrar = static function (string $valor): string {
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
};
?>

<?php if ($erro !== ""): ?>
    <p style="color:red;"><?= $mostrar($erro) ?></p>
    <p><a href="AGENDAMENTO/agendamento.php">Voltar ao agendamento</a></p>
<?php else: ?>
    <p><?= $mostrar($sucesso) ?></p>
    <p><?= $mostrar($hora) ?> — <?= $mostrar($tutor) ?> — <?= $mostrar($pet) ?> — <?= $mostrar($servico) ?></p>
    <p><a href="PAINEL/painel.php">Ver no painel</a></p>
<?php endif; ?>

<?php require_once 'includes/rodape.php'; ?>
