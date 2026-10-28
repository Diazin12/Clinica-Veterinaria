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

                <a href="../INICIO/tela_inicial.html" class="button">
                    Inicio
                </a>

                <a href="../INICIO/tela_inicial.html#servicos" class="button">
                    Serviços
                </a>

            </nav>


        </div>

        </header>

    
        <div class="conteudo">

            <!-- LADO ESQUERDO -->
            <section class="formulario">

                <h1>Agendar Consulta</h1>

                <form id="agendamento" class="agendamento"
                action="../agendar.php" method="POST">

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

                    <label for="tutor">Tutor</label><br>
                    <input type="text" id="tutor" name="tutor" required>
                    <br><br>
                    
                    <label for="servico">Serviço</label> <br>
                    <select id="servico" name="servico" required>
                        <option value="">Selecione o serviço</option>
                        <option value="Consulta">Consulta</option>
                        <option value="Vacinação">Vacinação</option>
                        <option value="Exame">Exame</option>
                    </select>
                    <br><br>

                    <label for="data">Data</label><br>
                    <input type="date" id="data" name="data" required>
                    <br><br>

                    <label for="hora">Horário</label><br>
                    <select id="hora" name="hora" required>
                        <option value="">Selecione um horário</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                    </select>
                    <br><br>

                    <button type="submit" class="button1">
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

</body>
</html>
