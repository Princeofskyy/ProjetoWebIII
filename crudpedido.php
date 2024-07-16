<?php
session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Pedidos.php'; 
include_once './classes/Produtos.php'; 

$cliente = new Cliente($db);

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}

$dados_cliente = $cliente->lerPorId($_SESSION['cliente_id']);
$nome_cliente = $dados_cliente['nome'];
$email_cliente = $dados_cliente['email'];
$telefone_cliente = $dados_cliente['fone'];

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];

function getOptionDetails($conn, $id) {
    $sql = "SELECT * FROM produtos WHERE id_produto = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$detalhes_pedido = array();
$total_itens = 0;

foreach ($carrinho as $id => $quantidade) {
    $details = getOptionDetails($db, $id);

    if ($details && is_array($details)) {
        $total_itens += $details['preco'] * $quantidade;
        $detalhes_pedido[] = array(
            'nome' => $details['nome'],
            'preco' => $details['preco'],
            'quantidade' => $quantidade,
            'imagem' => $details['imagem']
        );
    }
}

$taxa_entrega = 7.00;
$total_pedido = $total_itens + $taxa_entrega;

$confirmacao_pedido = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['endereco_entrega'])) {
    $_SESSION['endereco_entrega'] = $_POST['endereco_entrega'];

    if (isset($_POST['forma_pagamento'])) {
        $forma_pagamento = $_POST['forma_pagamento'];

        $pagamento_pedido = false;
        if ($forma_pagamento === 'cartao') {
            $pagamento_pedido = true; 
        }

        $pedidoCriadoComSucesso = false;

        foreach ($carrinho as $id => $quantidade) {
            $produto = new Produto($db); 
            $detalhes_produto = $produto->lerPorId($id);

            if ($detalhes_produto) {
                $pedido = new Pedido(
                    $_SESSION['cliente_id'],
                    $id,
                    $quantidade, 
                    $total_pedido,
                    '', 
                    $_SESSION['endereco_entrega'],
                    date('Y-m-d'), 
                    'Pendente', 
                    $pagamento_pedido
                );

                if (Pedido::criarPedido($db, $pedido)) {
                    $pedidoCriadoComSucesso = true;
                } else {
                    $confirmacao_pedido = 'Erro ao criar pedido.';
                    break; 
                }
            } else {
                $confirmacao_pedido = 'Produto não encontrado no banco de dados.';
                break; 
            }
        }

        if ($pedidoCriadoComSucesso) {
            unset($_SESSION['carrinho']);
            header('Location: confirmacao_pedido.php');
            exit();
        }
    } else {
        $confirmacao_pedido = 'Por favor, selecione uma forma de pagamento.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/crudpedido.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <a class="navbar-brand" href="portalcliente.php">Portal Cliente</a>
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
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Finalizar Pedido</h1>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Detalhes do Pedido</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> <?php echo $nome_cliente; ?></p>
                        <p><strong>Email:</strong> <?php echo $email_cliente; ?></p>
                        <p><strong>Telefone:</strong> <?php echo $telefone_cliente; ?></p>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="endereco_entrega" class="form-label">Endereço de Entrega</label>
                                <input type="text" class="form-control" id="endereco_entrega" name="endereco_entrega" value="<?php echo isset($_SESSION['endereco_entrega']) ? $_SESSION['endereco_entrega'] : ''; ?>" required>
                            </div>
                            
                            <!-- Seleção de Forma de Pagamento -->
                            <div class="mb-3">
                                <label for="forma_pagamento" class="form-label">Forma de Pagamento:</label>
                                <select class="form-select" id="forma_pagamento" name="forma_pagamento" required>
                                    <option value="">Selecione...</option>
                                    <option value="dinheiro">Dinheiro/PIX</option>
                                    <option value="cartao">Cartão de Crédito/Débito</option>
                                </select>
                            </div>

                            <?php foreach ($detalhes_pedido as $item): ?>
                                <div class="mb-3">
                                    <h5>Produto: <?php echo $item['nome']; ?></h5>
                                    <img src="<?php echo $item['imagem']; ?>" alt="<?php echo $item['nome']; ?>" class="img-thumbnail" style="max-width: 100px;">
                                    <p><strong>Preço Unitário:</strong> R$<?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                    <p><strong>Quantidade:</strong> <?php echo $item['quantidade']; ?></p>
                                </div>
                            <?php endforeach; ?>

                            <!-- Total do Pedido -->
                            <p><strong>Taxa de Entrega:</strong> R$<?php echo number_format($taxa_entrega, 2, ',', '.'); ?></p>
                            <p><strong>Total do Pedido:</strong> R$<?php echo number_format($total_pedido, 2, ',', '.'); ?></p>
                            
                            <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
                        </form>
                    </div>
                </div>
                <?php if (!empty($confirmacao_pedido)): ?>
                    <div class="alert alert-info"><?php echo $confirmacao_pedido; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-9zgkKu4KfY8DnBp4FREcQUb6j0+MVW8YYJw+2DSm35Kc2U0/bbcK9VaLye9uH0X2"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-Q1nPexj3T0MXxSFSv8FVlJkLzyt/tfR8L/3JS+SWaxPbFTStHoe9uFSpCR5fjbl"
        crossorigin="anonymous"></script>
</body>
</html>
