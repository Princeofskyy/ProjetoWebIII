<?php
// Verificar se a sessão está iniciada
session_start();

// Redirecionar se não houver uma sessão de cliente ativa
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Pedido Confirmado!</h4>
            <p>Seu pedido foi confirmado com sucesso.</p>
            <hr>
            <p class="mb-0">Redirecionando para o Portal do Cliente...</p>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = 'portalcliente.php';
        }, 3000); // Redirecionar após 3 segundos
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-9zgkKu4KfY8DnBp4FREcQUb6j0+MVW8YYJw+2DSm35Kc2U0/bbcK9VaLye9uH0X2"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-Q1nPexj3T0MXxSFSv8FVlJkLzyt/tfR8L/3JS+SWaxPbFTStHoe9uFSpCR5fjbl"
        crossorigin="anonymous"></script>
</body>
</html>
