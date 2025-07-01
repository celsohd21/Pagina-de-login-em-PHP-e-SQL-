<?php
// Arquivo: templates/header.php
require_once __DIR__ . '/../conexao.php';

// Proteção da página: verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$nome_usuario = htmlspecialchars($_SESSION['usuario_nome']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina ?? 'Gerenciador de Produtos'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gerenciador de Produtos</h1>
            <nav>
                <span>Olá, <?php echo $nome_usuario; ?>!</span>
                <a href="dashboard.php">Início</a>
                <a href="logout.php">Sair</a>
            </nav>
        </div>
    </header>
    <main class="container">
