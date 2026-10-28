<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$tituloPagina = $tituloPagina ?? 'Clínica Veterinária';
$cssPagina = $cssPagina ?? 'INICIO/tela_ini.css';
$paginaAtual = $paginaAtual ?? '';
$prefixoRaiz = $prefixoRaiz ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPagina, ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>

    <header class="cabecalho">

        <div class="all">

            <a href="https://www.unifio.edu.br/home/">
                <img class="logo"
                src="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>INICIO/logo_vet.png"
                alt="Logo Unifio">
            </a>

            <nav class="menu">

                <a href="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>INICIO/tela_inicial.html" class="button">
                    Inicio
                </a>

                <a href="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>INICIO/tela_inicial.html#servicos" class="button">
                    Serviços
                </a>

                <a href="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>AGENDAMENTO/agendamento.php" class="button">
                    Agendamentos
                </a>

                <a href="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>PAINEL/painel.php" class="button <?= $paginaAtual === 'painel' ? 'painel-ativo' : '' ?>">
                    Painel
                </a>

                <?php if ($paginaAtual === 'painel'): ?>
                    <a href="<?= htmlspecialchars($prefixoRaiz, ENT_QUOTES, 'UTF-8') ?>INICIO/tela_inicial.html" class="ent">
                        Sair
                    </a>
                <?php endif; ?>

            </nav>

        </div>

    </header>

    <main>
