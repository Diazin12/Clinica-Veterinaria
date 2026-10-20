<?php

$pets = [];

$arquivo = __DIR__ . '/../pets_cadastrados.txt';

if (file_exists($arquivo)) {

    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($linhas as $linha) {

        if (preg_match('/^Nome:\s*(.*?)\s*\|/', $linha, $resultado)) {

            $nome = trim($resultado[1]);

            if ($nome !== '') {
                $pets[] = $nome;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AGENDAMENTO </title>
    <link rel="stylesheet" href="agendamento.css">
</head>
<body>
        <header class="cabecalho">

        <div class="all">

            <!-- Logo -->
            <a href="https://www.unifio.edu.br/home/">
                <img class="logo"
                src="logo_vet.png"
                alt="Logo Unifio">
            </a>

            <!-- Menu -->
            <nav class="menu">

                <a href="tela_inicial.html" class="button">
                    Inicio
                </a>

                <a href="#" class="button">
                    Serviços
                </a>

            </nav>


        </div>

        </header>

    
        <div class="conteudo">

            <!-- LADO ESQUERDO -->
            <section class="formulario">

                <h1>Agendar Consulta</h1>

                <form class="agendamento"
                action="processa_pet.php" method="POST">

                    <label for="pet">Pet</label><br>
                    <select id="pet" name="pet" required>
                    <option value="">Selecione seu pet</option>
                    <?php foreach ($pets as $nome): ?>
                    <option value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                    <br><br>
                    
                    <label>Serviço</label> <br>
                    <select>
                        <option>Selecione o serviço</option>
                        <option>Consulta</option>
                        <option>Vacinação</option>
                        <option>Exames</option>
                    </select>
                    <br><br>

                    <label>Data</label><br>
                    <input type="date">
                    <br><br>

                    <label>Horário</label><br>
                    <select>
                        <option>Selecione um horário</option>
                        <option>08:00</option>
                        <option>09:00</option>
                        <option>10:00</option>
                    </select>
                    <br><br>

                    <button type="button" class = "button1">
                        Verificar disponibilidade
                    </button>

                </form>
            </section>

                


            <!-- LADO DIREITO -->
            <section class="horarios">

                <h1>Horários disponíveis</h1>
                <p>Segunda, 15 de Setembro de 2026</p>

                <div class="grade-horarios">

                    <button>08:00</button>
                    <button class="selecionado">09:00</button>
                    <button>10:00</button>

                    <button>11:00</button>
                    <button>13:00</button>
                    <button>14:00</button>

                    <button>15:00</button>
                    <button>16:00</button>
                    <button>17:00</button>

                </div>

                <div class="disponivel">
                    Selecione um horário.
                </div>

                <button type="submit" form="agendamento" class="confirmar">
                    Confirmar Agendamento
                </button>

            </section>

        </div>

    </main>

</body>
</html>
