<?php
session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';

// Verificar se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

// Obter dados do cliente logado
$cliente = new Cliente($db);
$dados_cliente = $cliente->lerPorId($_SESSION['cliente_id']);

// Dados do cliente
$nome_cliente = $dados_cliente['nome'];
$email_cliente = $dados_cliente['email'];
$telefone_cliente = $dados_cliente['fone'];
$endereco_cliente = $dados_cliente['endereco'];
$cep_cliente = $dados_cliente['cep'];
$bairro_cliente = $dados_cliente['bairro'];
$cidade_cliente = $dados_cliente['cidade'];
$complemento_cliente = $dados_cliente['complemento'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid">
            <a class="navbar-brand" href="portalcliente.php">Voltar ao Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="meuspedidos.php"><i class="bi bi-bag"></i> Meus pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrinho.php">
                            <i class="bi bi-cart"></i> Carrinho
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout_cliente.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="row text-center">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Seus Dados</h5>
                        <p class="card-text"><strong>Nome:</strong> <?php echo $nome_cliente; ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo $email_cliente; ?></p>
                        <p class="card-text"><strong>Telefone:</strong> <?php echo $telefone_cliente; ?></p>
                        <p class="card-text"><strong>Endereço:</strong> <?php echo $endereco_cliente; ?></p>
                        <p class="card-text"><strong>CEP:</strong> <?php echo $cep_cliente; ?></p>
                        <p class="card-text"><strong>Bairro:</strong> <?php echo $bairro_cliente; ?></p>
                        <p class="card-text"><strong>Cidade:</strong> <?php echo $cidade_cliente; ?></p>
                        <?php if (!empty($complemento_cliente)): ?>
                            <p class="card-text"><strong>Complemento:</strong> <?php echo $complemento_cliente; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center mt-5">
    <p>&copy; <?php echo date('Y'); ?> Hamburgueria QI Delicia. Todos os direitos reservados.</p></p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
