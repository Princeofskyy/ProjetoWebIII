<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Cliente.php';
include_once './classes/Usuario.php'; 

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: portal.php');
    exit();
}

$cliente = new Cliente($db);

// Processar exclusão de cliente
if (isset($_GET['deletar'])) {
    $id_cliente = $_GET['deletar'];
    $cliente->deletar($id_cliente);
    header('Location: crudclientes.php');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados dos clientes com filtros
$dados = $cliente->ler($search, $order_by);

// Obter dados do usuário logado
$usuario = new Usuario($db); // Instância do objeto Usuario
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal de Clientes</title>
    <link rel="stylesheet" href="./css/clientes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<header class="header">
    <h1>Bem-vindo ao Portal de Clientes</h1>
    <nav>
    <?php
        // Verifica se o usuário é administrador
        if ($dados_usuario['admin']) {
            echo '<a href="admin.php">Home</a>'; 
        } else {
            echo '<a href="portal.php">Home</a>'; 
        }
        ?>
            <a href="registrarcli.php">Adicionar Cliente</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <!-- Formulário para filtro -->
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por nome ou email"
                value="<?php echo htmlspecialchars($search); ?>">
            <label>
                <input type="radio" name="order_by" value="" <?php if ($order_by == '') echo 'checked'; ?>> Normal
            </label>
            <label>
                <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'nome') echo 'checked'; ?>>
                Ordem Alfabética
            </label>
            <label>
                <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'sexo') echo 'checked'; ?>>
                Sexo
            </label>
            <button type="submit">Pesquisar</button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Fone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id_cliente']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="editar_clientes.php?id=<?php echo $row['id_cliente']; ?>">Editar</a>
                    <a href="crudclientes.php?deletar=<?php echo $row['id_cliente']; ?>">Deletar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Hamburgueria QI Delicia. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
