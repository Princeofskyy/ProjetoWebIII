<?php
session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Pedidos.php';
include_once './classes/Produtos.php';

$cliente = new Cliente($db);
$produto = new Produto($db);

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

$dados_cliente = $cliente->lerPorId($_SESSION['cliente_id']);
$nome_cliente = $dados_cliente['nome'];
$email_cliente = $dados_cliente['email'];
$telefone_cliente = $dados_cliente['fone'];

function getPedidosCliente($conn, $id_cliente) {
    $sql = "SELECT * FROM pedidos WHERE id_cliente = :id_cliente";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$pedidos_cliente = getPedidosCliente($db, $_SESSION['cliente_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/meuspedidos.css">
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">
                            <i class="bi bi-person-circle"></i> Perfil
                        </a>
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

    <div class="container mt-5">
        <h1 class="text-center">Meus Pedidos</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php if (!empty($pedidos_cliente)): ?>
                    <?php foreach ($pedidos_cliente as $pedido): ?>
                        <?php 
                        $produto_detalhes = $produto->lerPorId($pedido['id_produto']);
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Pedido #<?php echo $pedido['id_pedido']; ?></h5>
                                <p class="card-text"><strong>Data:</strong> <?php echo $pedido['data_pedido']; ?></p>
                                <p class="card-text"><strong>Status:</strong> <?php echo $pedido['status_pedido']; ?></p>
                                <p class="card-text"><strong>Valor Total:</strong> R$ <?php echo number_format($pedido['preco_final'], 2, ',', '.'); ?></p>
                                <p class="card-text"><strong>Produto:</strong> <?php echo $produto_detalhes['nome']; ?></p>
                                <p class="card-text"><strong>Descrição:</strong> <?php echo $produto_detalhes['descricao']; ?></p>
                                <?php if (!empty($produto_detalhes['imagem'])): ?>
                                    <?php 
                                    $image_path = './' . $produto_detalhes['imagem'];
                                    if (file_exists($image_path)) {
                                        echo '<img src="' . $image_path . '" alt="' . $produto_detalhes['nome'] . '" class="img-fluid">';
                                    } else {
                                        echo '<p><strong>Imagem não encontrada:</strong> ' . $image_path . '</p>';
                                    }
                                    ?>
                                <?php else: ?>
                                    <p><strong>Sem imagem disponível.</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum pedido cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Hamburgueria QI Delicia. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12ER9tU1qPcKoLHg1p8o4DO2Lu7/7WoI5vGKBOkCp4hJov0v" crossorigin="anonymous"></script>
</body>
</html>
