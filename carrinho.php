<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php';

$produto = new Produto($db);

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];

function getProdutoDetails($id, $produto) {
    return $produto->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Carrinho</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/carrinhopedido.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <a class="navbar-brand" href="portalcliente.php">Portal Cliente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                </ul>
                <ul class="navbar-nav">
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

    <main class="container mt-5">
        <h2>Seu Carrinho</h2>
        <div class="row">
            <?php
            $subtotal = 0;
            foreach ($carrinho as $id => $quantidade) :
                $details = getProdutoDetails($id, $produto);
                if ($details) {
                    $subtotal += $details['preco'] * $quantidade;
            ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $details['imagem']; ?>" class="card-img-top" alt="<?php echo $details['nome']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $details['nome']; ?></h5>
                        <p class="card-text"><?php echo $details['descricao']; ?> - R$ <?php echo number_format($details['preco'], 2, ',', '.'); ?></p>
                        <p class="card-text">Quantidade: <?php echo $quantidade; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="remover_do_carrinho.php?id=<?php echo $id; ?>" class="btn btn-danger">Remover</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            endforeach;
            ?>
        </div>
        <?php if (empty($carrinho)) : ?>
            <p class="text-center">Seu carrinho está vazio.</p>
        <?php else : ?>
        <div class="row mt-4">
            <div class="col">
                <p>Tele Entrega: R$ 7</p>
                <h4>Subtotal: R$ <?php echo number_format($subtotal + 7, 2, ',', '.'); ?></h4>
                <form action="crudpedido.php" method="POST">
                    <?php foreach ($carrinho as $id => $quantidade) : ?>
                        <input type="hidden" name="id_produto[]" value="<?php echo $id; ?>">
                        <input type="hidden" name="quantidade[]" value="<?php echo $quantidade; ?>">
                    <?php endforeach; ?>
                    <input type="hidden" name="acao" value="finalizar_pedido">
                    <button type="submit" class="btn btn-success">Finalizar Pedido</button>
                </form>
                <a href="portalcliente.php" class="btn btn-secondary">Continuar Comprando</a>
                <a href="remover_carrinho.php" class="btn btn-warning">Remover Todos</a>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer class="text-center mt-5">
        <p>&copy; 2024 Hamburgueria QI Delicia. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
