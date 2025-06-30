<?php
// Arquivo: acao_registrar.php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    // Verifica se o email já existe
    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = mysqli_prepare($conexao, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        header("Location: registrar.php?erro=Este email já está cadastrado.");
        exit();
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo usuário no banco
    $sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conexao, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "sss", $nome, $email, $senha_hash);

    if (mysqli_stmt_execute($stmt_insert)) {
        header("Location: login.php?sucesso=Usuário registrado com sucesso! Faça o login.");
        exit();
    } else {
        header("Location: registrar.php?erro=Ocorreu um erro ao registrar. Tente novamente.");
        exit();
    }
}
?>