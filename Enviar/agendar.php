<?php
require_once __DIR__ . '/dados/consultas.php';

$erro = '';
$sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet = trim((string) ($_POST['pet'] ?? ''));
    $tutor = trim((string) ($_POST['tutor'] ?? ''));
    $servico = trim((string) ($_POST['servico'] ?? ''));
    $data = trim((string) ($_POST['data'] ?? ''));
    $hora = trim((string) ($_POST['hora'] ?? ''));
    $servicosValidos = ['Consulta', 'Vacinação', 'Exame'];
    $dataValida = DateTime::createFromFormat('!Y-m-d', $data);

    if ($pet === '' || $tutor === '' || $servico === '' || $data === '' || $hora === '') {
        $erro = 'Preencha todos os campos.';
    } elseif (!in_array($servico, $servicosValidos, true) || !$dataValida || $dataValida->format('Y-m-d') !== $data) {
        $erro = 'Informe um serviço e uma data válidos.';
    } elseif ($data < date('Y-m-d')) {
        $erro = 'A data não pode estar no passado.';
    } elseif (!preg_match('/^(?:08|09|10|11|12|13|14|15|16|17|18):(?:00|30)$/', $hora) || $hora > '18:00') {
        $erro = 'Atendimento apenas das 08:00 às 18:00.';
    } else {
        foreach ($consultas as $consulta) {
            if ($consulta['veterinario'] === 'Dra.Brinquedos' && $consulta['data'] === $data && $consulta['hora'] === $hora && $consulta['status'] !== 'cancelado') {
                $erro = 'Esse horário já está ocupado.';
                break;
            }
        }
    }
    if ($erro === '') {
        $consultas[] = [
            'id' => (count($consultas) ? max(array_column($consultas, 'id')) : 0) + 1,
            'pet' => $pet, 'tutor' => $tutor, 'servico' => $servico,
            'veterinario' => 'Dra.Brinquedos', 'data' => $data,
            'hora' => $hora, 'status' => 'agendado',
        ];
        $sucesso = 'Agendamento realizado com sucesso.';
    }
}
require_once __DIR__ . '/includes/cabecalho.php';
?>
<h1>Novo agendamento</h1>
<?php if ($erro !== ''): ?><p role="alert"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<?php if ($sucesso !== ''): ?><p><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<form method="post" action="agendar.php">
    <label>Pet <input name="pet" required></label>
    <label>Tutor <input name="tutor" required></label>
    <label>Serviço <select name="servico" required><option value="">Selecione</option><option>Consulta</option><option>Vacinação</option><option>Exame</option></select></label>
    <label>Data <input type="date" name="data" min="<?= date('Y-m-d') ?>" required></label>
    <label>Horário <input type="time" name="hora" min="08:00" max="18:00" step="1800" required></label>
    <button type="submit">Agendar</button>
</form>
<?php require_once __DIR__ . '/includes/rodape.php'; ?>
