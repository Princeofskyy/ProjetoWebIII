<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    
    // Verifica se o produto está no carrinho
    if (isset($_SESSION['carrinho'][$produto_id])) {
        // Verifica se há mais de uma unidade do produto no carrinho
        if ($_SESSION['carrinho'][$produto_id] > 1) {
            // Remove apenas uma unidade do produto do carrinho
            $_SESSION['carrinho'][$produto_id]--;
        } else {
            // Remove o produto completamente do carrinho se houver apenas uma unidade
            unset($_SESSION['carrinho'][$produto_id]);
        }
    }
}

header('Location: carrinho.php');
exit();
?>
