<?php
require_once 'includes/cabecalho.php';
require_once 'dados/consultas.php';
?>

<h1>Consultas agendadas</h1>

<?php foreach ($consultas as $c): ?>
    <?php
    $rotulo = match ($c["status"]) {
        "confirmado" => "Confirmada",
        "agendado"   => "Aguardando confirmação",
        "concluido"  => "Concluída",
        default      => "Cancelada"
    };
    ?>
    <p><?= $c["pet"] ?> com <?= $c["veterinario"] ?> em <?= $c["data"] ?> às <?= $c["hora"] ?> (<?= $rotulo ?>)</p>
<?php endforeach; ?>

<?php require_once 'includes/rodape.php'; ?>
