<?php
// Arquivo: acao_login.php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido, inicia a sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: login.php?erro=Email ou senha inválidos.");
            exit();
        }
    } else {
        header("Location: login.php?erro=Email ou senha inválidos.");
        exit();
    }
}
?>