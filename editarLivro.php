<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codLivro'])) {
    $codLivro = sanitizarEntrada($_GET['codLivro']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM livro LEFT JOIN conteudo ON livro.codConteudo = conteudo.codConteudo WHERE livro.codLivro = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codLivro]);

    if ($stmt->rowCount() > 0) {
        $livro = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="header-gim">
        <div>
            <div class="ifsul2">IFSul Campus Venâncio Aires</div>
        </div>
    </div>
    <div class="content">
        <div id="cadastro">
            <form method="POST" action="processarEdicaoLivro.php" enctype="multipart/form-data">
                <h1>Edição de Livros</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codLivro" value="<?= $codLivro ?>">
                <input type="hidden" name="codConteudo" value="<?= $livro['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $livro['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $livro['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $livro['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $livro['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
                <p>
                    <label for="editoraLivro">Editora:</label>
                    <input type="text" id="editoraLivro" name="editoraLivro" value="<?= $livro['editoraLivro'] ?>" required>
                </p>

                <p>
                    <label for="capaLivro">Capa do Livro:</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($livro['capaLivro']) ?>" alt="Capa do Livro" style="width: 100px; height: 100px;"><br>
                    <input type="file" id="novaCapaLivro" name="novaCapaLivro">
                </p>

                <p>
                    <label for="anoLivro">Ano do Livro:</label>
                    <input type="text" id="anoLivro" name="anoLivro" value="<?= $livro['anoLivro'] ?>">
                </p>

                <p>
                    <label for="paginasLivro">Páginas do Livro:</label>
                    <input type="text" id="paginasLivro" name="paginasLivro" value="<?= $livro['paginasLivro'] ?>">
                </p>

                <p>
                    <label for="autorLivro">Autor do Livro:</label>
                    <input type="text" id="autorLivro" name="autorLivro" value="<?= $livro['autorLivro'] ?>">
                </p>

                <p>
                    <label for="generoLivro">Gênero do Livro:</label>
                    <input type="text" id="generoLivro" name="generoLivro" value="<?= $livro['generoLivro'] ?>">
                </p>

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
