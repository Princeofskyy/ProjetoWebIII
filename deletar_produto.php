<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php'; 
$produto = new Produto($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $produto->deletar($id);
    header('Location: crudprodutos.php'); 
    exit();
}
?>
