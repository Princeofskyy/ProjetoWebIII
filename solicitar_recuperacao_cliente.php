<?php
include_once './config/config.php';
include_once './classes/Cliente.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $cliente = new Cliente($db);
    $codigo = $cliente->gerarCodigoVerificacao($email);

    if ($codigo) {
        $mensagem = "<span class='msg'> Seu código de verificação é: $codigo. Por favor, anote o código e <a href='redefinir_senha_cliente.php'>clique aqui</a> para redefinir sua senha.</span>";
    } else {
        $mensagem = "<span class='msg'>E-mail não encontrado. </span>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="./css/recuperar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="recuperar-container">
        <h1>Recuperar Senha</h1>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            <div class="button-container">
                <input type="submit" value="Enviar">
                <input type="button" value="Voltar" onclick="window.location.href='index.php';">
            </div>
        </form>
        <p><?php echo $mensagem; ?></p>
    </div>
</body>
</html>
