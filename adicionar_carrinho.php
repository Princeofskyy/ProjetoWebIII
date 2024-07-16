<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php';

$produto = new Produto($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_produto = $data['id'];
    $quantidade = isset($data['quantidade']) ? intval($data['quantidade']) : 1;

    $produtoInfo = $produto->lerPorId($id_produto);

    if ($produtoInfo) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adicionar ou atualizar a quantidade do produto no carrinho
        if (isset($_SESSION['carrinho'][$id_produto])) {
            $_SESSION['carrinho'][$id_produto] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id_produto] = $quantidade;
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
?>
