<?php
// Arquivo: login.php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Gerenciador de Produtos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-login">
        <h2>Login</h2>
        <?php if (isset($_GET['erro'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['erro']); ?></p>
        <?php endif; ?>
        <form action="acao_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="registrar.php">Registre-se</a></p>
    </div>
</body>
</html>