<?php
session_start();
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Produtos.php';
$cliente = new Cliente($db);
$produto = new Produto($db);
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit();
}
$dados_cliente = $cliente->lerPorId($_SESSION['cliente_id']);
$nome_cliente = $dados_cliente['nome'];
function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
$produtos = $produto->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/clienteportal.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php echo saudacao() . ", " . $nome_cliente; ?>!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php"><i class="bi bi-person-circle"></i> Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="meuspedidos.php"><i class="bi bi-bag"></i> Meus pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrinho.php"><i class="bi bi-cart"></i> Carrinho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout_cliente.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-5">
        <div class="row text-center">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $produto['imagem']; ?>" class="card-img-top" alt="Imagem do <?php echo $produto['nome']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                            <p class="card-text"><?php echo $produto['descricao']; ?> - R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <input type="number" class="form-control mb-2 quantidade-input" data-option-id="<?php echo $produto['id_produto']; ?>" value="1" min="1">
                            <button class="btn btn-primary select-button" data-option-id="<?php echo $produto['id_produto']; ?>">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer class="text-center mt-5">
        <p>&copy; <?php echo date('Y'); ?> Hamburgueria QI Delicia. Todos os direitos reservados.</p></p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const optionId = this.getAttribute('data-option-id');
                    const quantidadeInput = document.querySelector('.quantidade-input[data-option-id="' + optionId + '"]');
                    const quantidade = quantidadeInput ? quantidadeInput.value : 1;
                    
                    if (this.textContent.trim() === 'Adicionar ao Carrinho') {
                        fetch('adicionar_carrinho.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: optionId, quantidade: quantidade })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = 'Ir ao Carrinho';
                                this.classList.remove('btn-primary');
                                this.classList.add('btn-success');
                            } else {
                                alert('Erro ao adicionar ao carrinho: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert('Erro ao processar a solicitação.');
                        });
                    } else { 
                        window.location.href = 'carrinho.php';
                    }
                });
            });
        });
    </script>
</body>
</html>
