<?php

session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
$usuario = new Usuario($db);

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: portal.php');
    exit();
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Função para determinar a saudação
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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa Usuários</title>
    <link rel="stylesheet" href="./css/inicial.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <div class="header-buttons">
            <a class="logout-button" href="logout.php">Logout</a>
        </div>
    </header>
    <main>
        <div class="porta-container">
            <div class="porta">
            <a class="button add-button" href="crudusuario.php">Gerenciar Usuários</a>
                <a class="button add-button" href="crudclientes.php">Gerenciar Clientes</a>
                <a class="button add-button" href="crudprodutos.php">Gerenciar Produtos</a>
            </div>
        </div>
    </main>

    <footer>
    <p>&copy; <?php echo date('Y'); ?> Hamburgueria QI Delicia. Todos os direitos reservados.</p></p>
    </footer>

</body>
</html>

