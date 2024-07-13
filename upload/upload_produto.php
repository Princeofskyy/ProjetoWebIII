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
    if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio_destino = './uploads/';
        
        $nome_arquivo = uniqid('produto_') . '_' . $_FILES['imagem']['name'];
        
        $caminho_arquivo = $diretorio_destino . $nome_arquivo;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_arquivo)) {
            // Dados do produto
            $nome = $_POST['nome'];
            $preco = $_POST['preco'];
            $descricao = $_POST['descricao'];
            
            // Adiciona o produto ao banco de dados, incluindo o caminho da imagem
            $produto->adicionar($nome, $preco, $descricao, $caminho_arquivo);
            
            // Redireciona para a página de listagem de produtos ou outra página
            header('Location: crudprodutos.php'); 
            exit();
        } else {
            echo 'Erro ao mover o arquivo para o diretório de destino.';
        }
    } else {
        echo 'Erro no upload do arquivo.';
    }
} else {
    echo 'Método de requisição inválido.';
}
?>
