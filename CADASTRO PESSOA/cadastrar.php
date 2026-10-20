<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro_pessoa.html', true, 303);
    exit;
}

header('Content-Type: text/html; charset=UTF-8');

function voltarComErro(string $mensagem): void
{
    http_response_code(422);
    $mensagemSegura = htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro no cadastro</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef6ff; margin: 0; display: grid; min-height: 100vh; place-items: center; }
        .mensagem { box-sizing: border-box; width: min(100% - 32px, 510px); background: #fff; border: 3px solid #b5cbe8; border-radius: 10px; padding: 32px; text-align: center; box-shadow: 0 8px 20px #0002; }
        h1 { margin-top: 0; color: #222; font-size: 26px; }
        p { color: #333; line-height: 1.5; }
        a { display: inline-block; margin-top: 8px; background: #ff8c00; color: #fff; padding: 10px 16px; border-radius: 5px; text-decoration: none; }
        a:hover { background: #e67e00; }
    </style>
</head>
<body>
    <main class="mensagem">
        <h1>Não foi possível concluir o cadastro</h1>
        <p>{$mensagemSegura}</p>
        <p><a href="cadastro_pessoa.html">Voltar ao formulário</a></p>
    </main>
</body>
</html>
HTML;
    exit;
}

$nome = trim((string) ($_POST['nome'] ?? ''));
$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$telefone = trim((string) ($_POST['telefone'] ?? ''));
$endereco = trim((string) ($_POST['endereco'] ?? ''));
$senha = (string) ($_POST['senha'] ?? '');

if ($nome === '' || $email === '' || $telefone === '' || $senha === '') {
    voltarComErro('Preencha todos os campos obrigatórios.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    voltarComErro('Informe um e-mail válido.');
}

function tamanho(string $valor): int
{
    return function_exists('mb_strlen') ? mb_strlen($valor) : strlen($valor);
}

if (tamanho($nome) > 100 || tamanho($email) > 150 || tamanho($telefone) > 20 || tamanho($endereco) > 200) {
    voltarComErro('Um dos campos excede o tamanho permitido.');
}

if (tamanho($senha) < 6) {
    voltarComErro('A senha deve ter pelo menos 6 caracteres.');
}

$arquivoCadastros = __DIR__ . DIRECTORY_SEPARATOR . 'cadastros.json';
$novoCadastro = [
    'nome' => $nome,
    'email' => $email,
    'telefone' => $telefone,
    'endereco' => $endereco,
    'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
    'criado_em' => date('c'),
];

$arquivo = fopen($arquivoCadastros, 'c+');
if ($arquivo === false) {
    voltarComErro('Não foi possível salvar o cadastro. Verifique a permissão da pasta.');
}

if (!flock($arquivo, LOCK_EX)) {
    fclose($arquivo);
    voltarComErro('Não foi possível acessar os cadastros neste momento. Tente novamente.');
}

try {
    rewind($arquivo);
    $conteudo = stream_get_contents($arquivo);
    $cadastros = json_decode($conteudo ?: '[]', true, 512, JSON_THROW_ON_ERROR);

    if (!is_array($cadastros)) {
        throw new RuntimeException('Formato de cadastros inválido.');
    }

    foreach ($cadastros as $cadastro) {
        if (($cadastro['email'] ?? '') === $email) {
            flock($arquivo, LOCK_UN);
            fclose($arquivo);
            voltarComErro('Este e-mail já está cadastrado.');
        }
    }

    $cadastros[] = $novoCadastro;
    $json = json_encode($cadastros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

    rewind($arquivo);
    ftruncate($arquivo, 0);
    if (fwrite($arquivo, $json . PHP_EOL) === false) {
        throw new RuntimeException('Falha ao gravar o arquivo.');
    }
} catch (JsonException | RuntimeException $erro) {
    flock($arquivo, LOCK_UN);
    fclose($arquivo);
    voltarComErro('Não foi possível processar os cadastros existentes.');
}

flock($arquivo, LOCK_UN);
fclose($arquivo);

$nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Cadastro realizado</title>
<style>body{font-family:Arial,sans-serif;background:#eef6ff;margin:0;display:grid;min-height:100vh;place-items:center}.mensagem{background:#fff;border:3px solid #b5cbe8;border-radius:10px;padding:32px;text-align:center;max-width:440px;box-shadow:0 8px 20px #0002}a{display:inline-block;background:#ff8c00;color:#fff;padding:10px 16px;border-radius:5px;text-decoration:none}</style>
</head>
<body>
    <main class="mensagem">
        <h1>Cadastro realizado com sucesso!</h1>
        <p>Olá, <?= $nomeSeguro ?>. Seus dados foram salvos.</p>
        <p><a href="../CADASTRO PET/cadastro_pet.html">Cadastrar pet</a></p>
    </main>
</body>
</html>
