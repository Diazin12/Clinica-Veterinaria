<?php
require_once 'dados/consultas.php';
require_once 'includes/cabecalho.php';
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
    <p><?= htmlspecialchars($c["pet"], ENT_QUOTES, 'UTF-8') ?> com <?= htmlspecialchars($c["veterinario"], ENT_QUOTES, 'UTF-8') ?> em <?= htmlspecialchars($c["data"], ENT_QUOTES, 'UTF-8') ?> às <?= htmlspecialchars($c["hora"], ENT_QUOTES, 'UTF-8') ?> (<?= $rotulo ?>)</p>
<?php endforeach; ?>

<?php require_once 'includes/rodape.php'; ?>
