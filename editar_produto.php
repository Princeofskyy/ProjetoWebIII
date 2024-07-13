<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php'; 

$produto = new Produto($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto = $_POST['id_produto'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem = $_FILES['imagem'];
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoImagem = 'uploads/' . $nomeArquivo;
        move_uploaded_file($imagem['tmp_name'], $caminhoImagem);

        $produto->atualizar($id_produto, $nome, $preco, $descricao, $caminhoImagem);
    } else {
 
        $produto->atualizar($id_produto, $nome, $preco, $descricao);
    }

    header('Location: crudprodutos.php');
    exit();
}

if (isset($_GET['id'])) {
    $id_produto = $_GET['id'];
    $row = $produto->lerPorId($id_produto);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="./css/editar_produto.css">
</head>
<body>
    <div class="container">
        <h2>Editar Produto</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produto" value="<?php echo $row['id_produto']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
            <br><br>
            <label for="preco">Preço:</label>
            <input type="number" name="preco" step="0.01" value="<?php echo $row['preco']; ?>" required>
            <br><br>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" rows="8" required><?php echo $row['descricao']; ?></textarea>
            <br><br>
            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem">
            <br><br>
            <?php if ($row['imagem']): ?>
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>" width="100">
                <br><br>
            <?php endif; ?>
            <input type="submit" class="button" value="Atualizar">
            <input type="button" class="button" value="Cancelar" onclick="window.location.href='crudprodutos.php'">
        </form>
    </div>
</body>
</html>
