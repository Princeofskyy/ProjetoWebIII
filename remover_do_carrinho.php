<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    
    if (isset($_SESSION['carrinho'][$produto_id])) {
        if ($_SESSION['carrinho'][$produto_id] > 1) {
            $_SESSION['carrinho'][$produto_id]--;
        } else {
            unset($_SESSION['carrinho'][$produto_id]);
        }
    }
}

header('Location: carrinho.php');
exit();
?>
