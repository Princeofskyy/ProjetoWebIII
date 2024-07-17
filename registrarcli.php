<?php
session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $complemento = $_POST['complemento'];
    $senha = $_POST['senha'];

    $cliente->criar($nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento, $senha);
    header('Location: crudclientes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/registre.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Adicionar Cliente</title>
</head>
<body>
    <div class="registrar-container">
        <h1>Cadastro de Cliente</h1>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="Insira seu nome:" required>
            <br>

            <label>MASCULINO</label>
            <input type="radio" name="sexo" value="M" required>

            <label>FEMININO</label>
            <input type="radio" name="sexo" value="F" required>
            <br>

            <label for="fone">Telefone:</label>
            <input type="text" name="fone" placeholder="Insira seu número:" required>
            <br>

            <label for="email">E-mail:</label>
            <input type="email" name="email" placeholder="E-mail:" required>
            <br>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" placeholder="Endereço:" required>
            <br>

            <label for="cep">CEP:</label>
            <input type="text" name="cep" placeholder="CEP:" required>
            <br>

            <label for="bairro">Bairro:</label>
            <input type="text" name="bairro" placeholder="Bairro:" required>
            <br>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" placeholder="Cidade:" required>
            <br>

            <label for="complemento">Complemento:</label>
            <input type="text" name="complemento" placeholder="Complemento:">
            <br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" placeholder="Senha:" required>
            <br>

            <input type="submit" value="Salvar">
            <input type="button" value="Voltar" onclick="window.history.back();" class="button">
        </form>
    </div>
</body>
</html>
