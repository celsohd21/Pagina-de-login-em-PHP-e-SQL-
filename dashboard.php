<?php
// Arquivo: dashboard.php
$titulo_pagina = "Dashboard";
include 'templates/header.php';

// Lógica de busca
$busca = isset($_GET['busca']) ? mysqli_real_escape_string($conexao, $_GET['busca']) : '';
$sql = "SELECT * FROM produtos";
if ($busca) {
    $sql .= " WHERE nome LIKE '%$busca%'";
}
$sql .= " ORDER BY data_criacao DESC";

$resultado = mysqli_query($conexao, $sql);
?>

<div class="dashboard-header">
    <h2>Lista de Produtos</h2>
    <a href="adicionar_produto.php" class="btn">Adicionar Novo Produto</a>
</div>

<form method="GET" action="dashboard.php" class="form-busca">
    <input type="text" name="busca" placeholder="Pesquisar por nome..." value="<?php echo htmlspecialchars($busca); ?>">
    <button type="submit">Buscar</button>
</form>

<?php if (isset($_GET['msg'])): ?>
    <p class="success"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while($produto = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td>
                        <?php if (!empty($produto['imagem'])): ?>
                            <img src="produtos/imagens/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" width="100">
                        <?php else: ?>
                            Sem Imagem
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                    <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                    <td class="acoes">
                        <a href="editar_produto.php?id=<?php echo $produto['id']; ?>" class="btn-editar">Editar</a>
                        <button onclick="confirmarDelecao(<?php echo $produto['id']; ?>)" class="btn-remover">Remover</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Nenhum produto cadastrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'templates/footer.php'; ?>