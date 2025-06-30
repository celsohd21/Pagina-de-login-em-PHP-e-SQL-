<?php
// Arquivo: acao_adicionar_editar_produto.php
require 'conexao.php';

// Função para tratar o upload da imagem
function uploadImagem($imagem) {
    $pasta_destino = "produtos/imagens/";
    $nome_arquivo_original = $imagem['name'];
    $extensao = strtolower(pathinfo($nome_arquivo_original, PATHINFO_EXTENSION));
    $tipos_permitidos = ['jpg', 'jpeg', 'png'];
    $tamanho_maximo = 2 * 1024 * 1024; // 2MB

    // Validações
    if (!in_array($extensao, $tipos_permitidos)) {
        return ['sucesso' => false, 'erro' => 'Erro: Apenas arquivos JPG, JPEG e PNG são permitidos.'];
    }
    if ($imagem['size'] > $tamanho_maximo) {
        return ['sucesso' => false, 'erro' => 'Erro: O tamanho do arquivo não pode exceder 2MB.'];
    }

    // Gera nome único
    $nome_arquivo_novo = uniqid() . '.' . $extensao;
    $caminho_completo = $pasta_destino . $nome_arquivo_novo;

    // Move o arquivo
    if (move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
        return ['sucesso' => true, 'nome_arquivo' => $nome_arquivo_novo];
    } else {
        return ['sucesso' => false, 'erro' => 'Erro ao fazer upload da imagem.'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];

    // Dados comuns
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $nome_imagem = null;

    // Processa a imagem se enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $resultado_upload = uploadImagem($_FILES['imagem']);
        if ($resultado_upload['sucesso']) {
            $nome_imagem = $resultado_upload['nome_arquivo'];
        } else {
            // Tratar erro no upload
            header("Location: dashboard.php?msg=" . urlencode($resultado_upload['erro']));
            exit();
        }
    }

    if ($acao == 'adicionar') {
        $sql = "INSERT INTO produtos (nome, preco, quantidade, descricao, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sdis  s", $nome, $preco, $quantidade, $descricao, $nome_imagem);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?msg=Produto adicionado com sucesso!");
        } else {
            header("Location: dashboard.php?msg=Erro ao adicionar produto.");
        }

    } elseif ($acao == 'editar') {
        $id = $_POST['id'];
        $imagem_antiga = $_POST['imagem_antiga'];

        // Se uma nova imagem foi enviada, usa o novo nome, senão mantém o antigo
        $nome_imagem_final = $nome_imagem ?? $imagem_antiga;

        $sql = "UPDATE produtos SET nome = ?, preco = ?, quantidade = ?, descricao = ?, imagem = ? WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sdissi", $nome, $preco, $quantidade, $descricao, $nome_imagem_final, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Se uma nova imagem foi enviada com sucesso, deleta a antiga
            if ($nome_imagem && !empty($imagem_antiga) && file_exists("produtos/imagens/" . $imagem_antiga)) {
                unlink("produtos/imagens/" . $imagem_antiga);
            }
            header("Location: dashboard.php?msg=Produto atualizado com sucesso!");
        } else {
            header("Location: dashboard.php?msg=Erro ao atualizar produto.");
        }
    }
    exit();
}
?>