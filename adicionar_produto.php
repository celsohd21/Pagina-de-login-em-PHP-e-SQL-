<?php
$titulo_pagina = "Adicionar Produto";
include 'templates/header.php';
?>

<h2>Adicionar Novo Produto</h2>
<form action="acao_adicionar_editar_produto.php" method="POST" enctype="multipart/form-data" class="form-produto">
    <input type="hidden" name="acao" value="adicionar">
    
    <label for="nome">Nome do Produto:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" id="preco" name="preco" required>

    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"></textarea>

    <label for="imagem">Imagem (JPG, PNG - Máx 2MB):</label>
    <input type="file" id="imagem" name="imagem" accept=".jpg, .jpeg, .png">

    <button type="submit">Adicionar Produto</button>
</form>

<?php include 'templates/footer.php'; ?>