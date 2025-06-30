<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registro - Gerenciador de Produtos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-login">
        <h2>Registrar Novo Usuário</h2>
        <?php if (isset($_GET['erro'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['erro']); ?></p>
        <?php elseif (isset($_GET['sucesso'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['sucesso']); ?></p>
        <?php endif; ?>
        <form action="acao_registrar.php" method="POST">
            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" id="nome" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <button type="submit">Registrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
</body>
</html>