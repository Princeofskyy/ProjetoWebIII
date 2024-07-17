<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Produtos.php'; 
include_once './classes/Usuario.php'; 

// Obter dados do usuário logado
$usuario = new Usuario($db); // Instância do objeto Usuario
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];


$produto = new Produto($db);
$stmt = $produto->ler();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/crudproduto.css">
    <title>Lista de Produtos</title>
</head>
<body>
<header class="header">
        <h1>Bem-vindo ao Portal de Produtos</h1>
        <nav>
        <?php
        // Verifica se o usuário é administrador
        if ($dados_usuario['admin']) {
            echo '<a href="admin.php">Home</a>'; 
        } else {
            echo '<a href="portal.php">Home</a>'; 
        }
        ?>
            <a href="adicionar_produtos.php">Adicionar Produto</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="crud-produtos">
        <h1>Lista de Produtos</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?php echo $produto['id_produto']; ?></td>
                <td><?php echo $produto['nome']; ?></td>
                <td><?php echo $produto['preco']; ?></td>
                <td><?php echo $produto['descricao']; ?></td>
                <td><img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" width="100"></td>
                <td>
                    <a href="editar_produto.php?id=<?php echo $produto['id_produto']; ?>">Editar</a>
                    <a href="deletar_produto.php?id=<?php echo $produto['id_produto']; ?>" onclick="return confirm('Tem certeza que deseja deletar este produto?');">Deletar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Hamburgueria QI Delicia. Todos os direitos reservados.</p></p>
    </footer>
</body>
</html>
