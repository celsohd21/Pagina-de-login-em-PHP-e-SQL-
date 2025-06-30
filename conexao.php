<?php
// Arquivo: conexao.php

$servidor = 'localhost:3306'; // Endereço do servidor MySQL
$usuario_db = 'root'; // Usuário padrão do MySQL
$senha_db = 'admin'; // Senha padrão do MySQL
$banco = 'gerenciador_produtos_db'; // Nome do banco de dados

$conexao = new mysqli($servidor, $usuario_db, $senha_db, $banco);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Inicia a sessão em todas as páginas que incluírem este arquivo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>