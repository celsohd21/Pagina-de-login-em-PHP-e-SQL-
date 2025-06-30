<?php
// Arquivo: acao_deletar_produto.php
require 'conexao.php';

// Proteção da página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Pega o nome do arquivo da imagem para deletar o arquivo físico
    $sql_select = "SELECT imagem FROM produtos WHERE id = ?";
    $stmt_select = mysqli_prepare($conexao, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $resultado = mysqli_stmt_get_result($stmt_select);
    if ($produto = mysqli_fetch_assoc($resultado)) {
        $imagem_a_deletar = $produto['imagem'];
    }

    // 2. Deleta o registro do banco de dados
    $sql_delete = "DELETE FROM produtos WHERE id = ?";
    $stmt_delete = mysqli_prepare($conexao, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    if (mysqli_stmt_execute($stmt_delete)) {
        // 3. Se o registro foi deletado e existia uma imagem, deleta o arquivo
        if (!empty($imagem_a_deletar) && file_exists("produtos/imagens/" . $imagem_a_deletar)) {
            unlink("produtos/imagens/" . $imagem_a_deletar);
        }
        header("Location: dashboard.php?msg=Produto removido com sucesso!");
    } else {
        header("Location: dashboard.php?msg=Erro ao remover o produto.");
    }
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>