<?php

session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Processar login
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if ($dados_cliente = $cliente->login($email, $senha)) {
            $_SESSION['cliente_id'] = $dados_cliente['id_cliente'];
            error_log("Login bem-sucedido para o cliente ID: " . $dados_cliente['id_cliente']); // Debug
            header('Location: portalcliente.php');
            exit();
        } else {
            error_log("Falha no login para o email: $email"); // Debug
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/loginclientes.css">
    <title>Autenticação</title>
</head>
<body class="login">
    <div class="container">
        <form method="POST">
            <h1>Login</h1>
            <label for="email">E-mail:</label>
            <input type="email" name="email" placeholder="Insira o e-mail:" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" placeholder="Insira sua senha:" required>

            <input type="submit" value="Entrar" name="login">
        </form>
        <p>Não tem conta? <a href="./registrar_cliente.php">Registre-se aqui</a></p>
        <p><a href="./solicitar_recuperacao_cliente.php" class="esqueci">Esqueci a senha</a></p>
        <div class="mensagem">
            <?php
            if (isset($mensagem_erro)) {
                echo '<p>'.$mensagem_erro.'</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
