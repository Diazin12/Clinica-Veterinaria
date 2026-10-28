<?php
$tituloPagina = 'Painel do Atendente';
$cssPagina = 'painel.css';
$paginaAtual = 'painel';
$prefixoRaiz = '../';

require_once __DIR__ . '/../dados/consultas.php';
require_once __DIR__ . '/../dados/tutores.php';
require_once __DIR__ . '/../dados/pets.php';
require_once __DIR__ . '/../includes/cabecalho.php';

$hoje = date("Y-m-d");

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

$mostrar = static function ($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
};
?>

<div class="container">

    <div class="titulo-painel">
        <div class="icone-painel" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none">
                <rect x="8" y="12" width="48" height="44" rx="8" stroke="#00489C" stroke-width="4"/>
                <path d="M8 24h48" stroke="#00489C" stroke-width="4"/>
                <path d="M22 8v10M42 8v10" stroke="#00489C" stroke-width="4" stroke-linecap="round"/>
                <circle cx="44" cy="42" r="5" fill="#00489C"/>
                <circle cx="36" cy="36" r="3.2" fill="#00489C"/>
                <circle cx="52" cy="36" r="3.2" fill="#00489C"/>
                <circle cx="38" cy="50" r="3.2" fill="#00489C"/>
                <circle cx="50" cy="50" r="3.2" fill="#00489C"/>
            </svg>
        </div>
        <div>
            <h1>Painel do Atendente</h1>
            <p>Visualize e gerencie os agendamentos da clínica veterinária.</p>
        </div>
    </div>

    <div class="quadro">

        <nav class="abas">
            <a href="painel.php?aba=agendamentos" class="<?= $aba === 'agendamentos' ? 'aba-ativa' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                Agendamentos
            </a>
            <a href="painel.php?aba=tutores" class="<?= $aba === 'tutores' ? 'aba-ativa' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3.5"/><path d="M5 19c.8-3.5 3.4-5 7-5s6.2 1.5 7 5"/></svg>
                Tutores
            </a>
            <a href="painel.php?aba=pets" class="<?= $aba === 'pets' ? 'aba-ativa' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="15" rx="6" ry="4.5"/><circle cx="7" cy="9" r="2"/><circle cx="11" cy="6.5" r="2"/><circle cx="16" cy="6.5" r="2"/><circle cx="19" cy="9.5" r="2"/></svg>
                Pets
            </a>
        </nav>

        <?php if ($aba === "agendamentos"): ?>

            <div class="topo-tabela">
                <h2>Agendamentos</h2>
                <input type="date" value="<?= $hoje ?>">
            </div>

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
                    $classeConfirmar   = $c["status"] === "agendado" ? "btn-confirmar" : "btn-status " . $c["status"];

                    // Segundo botão: "Cancelar" só enquanto agendado ou confirmado
                    $bloqueiaCancelar  = ($c["status"] === "agendado" || $c["status"] === "confirmado") ? "" : "disabled";
                    ?>
                    <tr>
                        <td><?= $mostrar($c["hora"]) ?></td>
                        <td><?= $mostrar($c["tutor"]) ?></td>
                        <td><?= $mostrar($c["pet"]) ?></td>
                        <td><?= $mostrar($c["servico"]) ?></td>
                        <td><span class="status status-<?= $mostrar($c["status"]) ?>"><?= $rotulo ?></span></td>
                        <td>
                            <form action="painel.php?aba=agendamentos" method="POST">
                                <input type="hidden" name="id" value="<?= $mostrar($c["id"]) ?>">
                                <button type="submit" class="<?= $classeConfirmar ?>" name="acao" value="confirmar" <?= $bloqueiaConfirmar ?>><?= $textoConfirmar ?></button>
                                <button type="submit" class="btn-cancelar" name="acao" value="cancelar" <?= $bloqueiaCancelar ?>>Cancelar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php elseif ($aba === "tutores"): ?>

            <div class="topo-tabela">
                <h2>Tutores</h2>
            </div>

            <table>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Pet</th>
                </tr>
                <?php foreach ($tutores as $t): ?>
                    <tr>
                        <td><?= $mostrar($t["nome"]) ?></td>
                        <td><?= $mostrar($t["email"]) ?></td>
                        <td><?= $mostrar($t["telefone"]) ?></td>
                        <td><?= $mostrar($t["pet"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: ?>

            <div class="topo-tabela">
                <h2>Pets</h2>
            </div>

            <table>
                <tr>
                    <th>Pet</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Tutor</th>
                </tr>
                <?php foreach ($pets as $p): ?>
                    <tr>
                        <td><?= $mostrar($p["nome"]) ?></td>
                        <td><?= $mostrar($p["especie"]) ?></td>
                        <td><?= $mostrar($p["raca"]) ?></td>
                        <td><?= $mostrar($p["tutor"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php endif; ?>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/rodape.php'; ?>
