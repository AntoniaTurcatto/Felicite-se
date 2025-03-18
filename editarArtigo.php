<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codArtigo'])) {
    $codArtigo = sanitizarEntrada($_GET['codArtigo']); // Corrigido o nome da variável
    $conexao = conectarPDO();
    $sql = "SELECT * FROM artigo LEFT JOIN conteudo ON artigo.codConteudo = conteudo.codConteudo WHERE artigo.codArtigo = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codArtigo]);

    if ($stmt->rowCount() > 0) {
        $artigo = $stmt->fetch(PDO::FETCH_ASSOC); // Corrigido o nome da variável
    } else {
        header("Location: TelaPrincipalArtigos.php"); // Corrigido o redirecionamento
        exit();
    }
} else {
    header("Location: TelaPrincipalArtigos.php"); // Corrigido o redirecionamento
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artigo</title>
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
            <form method="POST" action="processarEdicaoArtigo.php" enctype="multipart/form-data">
                <h1>Edição de Artigos</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codArtigo" value="<?= $codArtigo ?>">
                <input type="hidden" name="codConteudo" value="<?= $artigo['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" type="text" placeholder="Nome" value="<?= $artigo['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $artigo['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $artigo['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $artigo['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
                <p>
                    <label for="linkArtigo">Link do artigo</label>
                    <input id="linkArtigo" name="linkArtigo" value="<?= $artigo['linkArtigo'] ?>" required>
                </p>

                <p>
                    <label for="resumoArtigo">Resumo do artigo</label>
                    <input id="resumoArtigo" name="resumoArtigo" value="<?= $artigo['resumoArtigo'] ?>" required="required" type="text" placeholder="Resumo" />
                </p>

                <p>
                    <label for="anoPublicacao">Ano do artigo</label>
                    <input id="anoPublicacao" name="anoPublicacao" value="<?= $artigo['anoPublicacao'] ?>" required="required" type="text" placeholder="Ano do artigo" />
                </p>

                <p>
                    <label for="autorArtigo">Autor do Artigo</label>
                    <input id="autorArtigo" name="autorArtigo" value="<?= $artigo['autorArtigo'] ?>" required="required" type="text" placeholder="Autor" />
                </p>
                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>