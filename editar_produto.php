<?php
// Arquivo: editar_produto.php
$titulo_pagina = "Editar Produto";
include 'templates/header.php';

$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$produto = mysqli_fetch_assoc($resultado);

if (!$produto) {
    echo "<p>Produto não encontrado.</p>";
    include 'templates/footer.php';
    exit();
}
?>

<h2>Editar Produto</h2>
<form action="acao_adicionar_editar_produto.php" method="POST" enctype="multipart/form-data" class="form-produto">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
    <input type="hidden" name="imagem_antiga" value="<?php echo htmlspecialchars($produto['imagem']); ?>">
    
    <label for="nome">Nome do Produto:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" id="preco" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>

    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($produto['quantidade']); ?>" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>

    <label for="imagem">Nova Imagem (JPG, PNG - Máx 2MB):</label>
    <input type="file" id="imagem" name="imagem" accept=".jpg, .jpeg, .png">
    <p>Imagem atual:</p>
    <?php if(!empty($produto['imagem'])): ?>
        <img src="produtos/imagens/<?php echo htmlspecialchars($produto['imagem']); ?>" width="150">
    <?php else: ?>
        <p>Nenhuma imagem cadastrada.</p>
    <?php endif; ?>


    <button type="submit">Atualizar Produto</button>
</form>

<?php include 'templates/footer.php'; ?>