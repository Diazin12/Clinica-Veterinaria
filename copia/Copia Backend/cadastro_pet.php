 <?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Array associativo com os dados do pet
    $pet = [
        "nome" => trim($_POST['pet'] ?? ''),
        "especie" => trim($_POST['especie'] ?? ''),
        "raca" => trim($_POST['raca'] ?? ''),
        "idade" => trim($_POST['idade'] ?? ''),
        "peso" => trim($_POST['peso'] ?? ''),
        "observacao" => trim($_POST['obs'] ?? '')
    ];  

    // Verificar campos obrigatórios
    if (
        $pet['nome'] === '' ||
        $pet['especie'] === '' ||
        $pet['raca'] === '' ||
        $pet['idade'] === '' ||
        $pet['peso'] === ''
    ) {
        exit("ERRO: Preencha todos os campos obrigatórios.");
    }

    // Organizar as informações para salvar no TXT
    $linhaDeTexto = "Nome: " . $pet['nome'] .
        " | Especie: " . $pet['especie'] .
        " | Raca: " . $pet['raca'] .
        " | Idade: " . $pet['idade'] .
        " | Peso: " . $pet['peso'] .
        " | Obs: " . $pet['observacao'] . PHP_EOL;

    // Caminho do arquivo TXT
    $arquivo = __DIR__ . '/pets_cadastrados.txt';

    // Salvar o cadastro
    $resultado = file_put_contents(
        $arquivo,
        $linhaDeTexto,
        FILE_APPEND | LOCK_EX
    );

    // Redirecionar após o cadastro
    if ($resultado !== false) {
        header("Location: AGENDAMENTO/agendamento.php");
        exit;
    } else {
        echo "ERRO: Não foi possível salvar o cadastro.";
    }

} else {
    echo "ERRO: Nenhum dado recebido.";
}


