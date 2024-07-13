<?php
session_start();

// Verificar se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

// Esvaziar o carrinho
unset($_SESSION['carrinho']);

// Redirecionar de volta para a página do carrinho
header('Location: carrinho.php');
exit();
?>
