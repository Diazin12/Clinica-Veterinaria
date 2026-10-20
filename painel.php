<?php
require_once 'includes/cabecalho.php';
require_once 'dados/consultas.php';
require_once 'dados/tutores.php';
require_once 'dados/pets.php';

$hoje = "2026-10-15"; // data simulada

// Aba atual (qualquer valor estranho cai em "agendamentos")
$aba = htmlspecialchars($_GET["aba"] ?? "agendamentos");
$aba = match ($aba) {
    "tutores" => "tutores",
    "pets"    => "pets",
    default   => "agendamentos"
};

// Botões Confirmar / Cancelar
$idAcao = htmlspecialchars($_POST["id"] ?? "");
$acao   = htmlspecialchars($_POST["acao"] ?? "");

$total = count($consultas);
for ($i = 0; $i < $total; $i++) {
    // Só altera a consulta clicada, e só se ainda estiver agendada ou confirmada
    if ($consultas[$i]["id"] == $idAcao && ($consultas[$i]["status"] === "agendado" || $consultas[$i]["status"] === "confirmado")) {
        $consultas[$i]["status"] = match ($acao) {
            "confirmar" => "confirmado",
            "cancelar"  => "cancelado",
            default     => $consultas[$i]["status"]
        };
    }
}
?>

<!-- Abas -->
<nav>
    <a href="painel.php?aba=agendamentos" class="<?= $aba === 'agendamentos' ? 'aba-ativa' : '' ?>">Agendamentos</a>
    <a href="painel.php?aba=tutores" class="<?= $aba === 'tutores' ? 'aba-ativa' : '' ?>">Tutores</a>
    <a href="painel.php?aba=pets" class="<?= $aba === 'pets' ? 'aba-ativa' : '' ?>">Pets</a>
</nav>

<?php if ($aba === "agendamentos"): ?>

    <h2>Agendamentos</h2>
    <input type="date" value="<?= $hoje ?>">

    <table>
        <tr>
            <th>Horário</th>
            <th>Tutor</th>
            <th>Pet</th>
            <th>Serviço</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($consultas as $c): ?>
            <?php
            $rotulo = match ($c["status"]) {
                "agendado"   => "Agendado",
                "confirmado" => "Confirmado",
                "concluido"  => "Concluído",
                default      => "Cancelado"
            };

            // Primeiro botão: "Confirmar" só enquanto está agendado
            $textoConfirmar    = $c["status"] === "agendado" ? "Confirmar" : $rotulo;
            $bloqueiaConfirmar = $c["status"] === "agendado" ? "" : "disabled";

            // Segundo botão: "Cancelar" só enquanto agendado ou confirmado
            $bloqueiaCancelar  = ($c["status"] === "agendado" || $c["status"] === "confirmado") ? "" : "disabled";
            ?>
            <tr>
                <td><?= $c["hora"] ?></td>
                <td><?= $c["tutor"] ?></td>
                <td><?= $c["pet"] ?></td>
                <td><?= $c["servico"] ?></td>
                <td><?= $rotulo ?></td>
                <td>
                    <form action="painel.php?aba=agendamentos" method="POST">
                        <input type="hidden" name="id" value="<?= $c["id"] ?>">
                        <button type="submit" name="acao" value="confirmar" <?= $bloqueiaConfirmar ?>><?= $textoConfirmar ?></button>
                        <button type="submit" name="acao" value="cancelar" <?= $bloqueiaCancelar ?>>Cancelar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php elseif ($aba === "tutores"): ?>

    <h2>Tutores</h2>

    <table>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Pet</th>
        </tr>
        <?php foreach ($tutores as $t): ?>
            <tr>
                <td><?= $t["nome"] ?></td>
                <td><?= $t["email"] ?></td>
                <td><?= $t["telefone"] ?></td>
                <td><?= $t["pet"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <h2>Pets</h2>

    <table>
        <tr>
            <th>Pet</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Tutor</th>
        </tr>
        <?php foreach ($pets as $p): ?>
            <tr>
                <td><?= $p["nome"] ?></td>
                <td><?= $p["especie"] ?></td>
                <td><?= $p["raca"] ?></td>
                <td><?= $p["tutor"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>

<?php require_once 'includes/rodape.php'; ?>
