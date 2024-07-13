<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Cliente.php'; 
include_once './classes/Usuario.php';

$cliente = new Cliente($db); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $complemento = $_POST['complemento'];
    
    $cliente->atualizar($id, $nome, $sexo, $fone, $email, $endereco, $cep, $bairro, $cidade, $complemento);
    header('Location: crudclientes.php');
    exit();
}

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $row = $cliente->lerPorId($id); 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="./css/editar_clientes.css">
</head>
<body>
    <div class="editar-container">
        <h1>Editar Cliente</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id_cliente']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
            <br><br>
            <label>Sexo:</label>
            <div class="radio-container">
                <label for="masculino_editar">
                    <input type="radio" id="masculino_editar" name="sexo" value="M" <?php echo $row['sexo'] === 'M' ? 'checked' : ''; ?> required> Masculino
                </label>
                <label for="feminino_editar">
                    <input type="radio" id="feminino_editar" name="sexo" value="F" <?php echo $row['sexo'] === 'F' ? 'checked' : ''; ?> required> Feminino
                </label>
            </div>
            <br><br>
            <label for="fone">Fone:</label>
            <input type="text" name="fone" value="<?php echo $row['fone']; ?>" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <br><br>
            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" value="<?php echo $row['endereco']; ?>" required>
            <br><br>
            <label for="cep">CEP:</label>
            <input type="text" name="cep" value="<?php echo $row['cep']; ?>">
            <br><br>
            <label for="bairro">Bairro:</label>
            <input type="text" name="bairro" value="<?php echo $row['bairro']; ?>">
            <br><br>
            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" value="<?php echo $row['cidade']; ?>">
            <br><br>
            <label for="complemento">Complemento:</label>
            <input type="text" name="complemento" value="<?php echo $row['complemento']; ?>">
            <br><br>
            <input type="submit" value="Atualizar">
            <button type="button" onclick="window.history.back();" class="button">Voltar</button>
        </form>
    </div>
</body>
</html>
