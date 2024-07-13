<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php'; 

$produto = new Produto($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];

    // Verificar se a imagem foi carregada corretamente
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoArquivo = 'upload/' . $nomeArquivo;

        // Mover o arquivo para a pasta de uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
            // Adicionar o produto ao banco de dados
            $produto->adicionar($nome, $preco, $descricao, $caminhoArquivo);
            header('Location: crudprodutos.php'); 
            exit();
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Erro ao carregar a imagem.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adicionarproduto.css">
    <title>Adicionar Produto</title>
</head>
<body>
    <div class="adicionar-produto">
        <h1>Cadastro de Produto</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="Insira o nome do produto:" required>
            <br>

            <label for="preco">Preço:</label>
            <input type="number" name="preco" step="0.01" placeholder="Insira o preço do produto:" required>
            <br>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" rows="5" placeholder="Insira a descrição do produto:" required></textarea>
            <br>
            
            <label for="imagem">Escolha a Imagem:</label>
            <input type="file" name="imagem" required>
            <br>

            <input type="submit" value="Salvar">
            <input type="button" value="Voltar" onclick="window.history.back();" class="button">
        </form>
    </div>
</body>
</html>
