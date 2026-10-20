<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Veterinária</title>
</head>
<body>
<header class="cabecalho">
    <div class="all">
        <a href="index.php">Clínica Veterinária</a>
        <nav class="menu" aria-label="Navegação principal">
            <a class="button" href="index.php">Consultas</a>
            <a class="button" href="agendar.php">Agendar</a>
        </nav>
    </div>
</header>
<main>
