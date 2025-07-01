<?php
// Arquivo: templates/footer.php
?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> - Instituto Federal de Educação, Ciência e Tecnologia do Sul de Minas Gerais</p>
    </footer>
    <script>
        // Função de confirmação para deletar
        function confirmarDelecao(id) {
            if (confirm("Tem certeza que deseja excluir este produto?")) {
                window.location.href = 'acao_deletar_produto.php?id=' + id;
            }
        }
    </script>
</body>
</html>
