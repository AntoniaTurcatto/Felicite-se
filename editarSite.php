<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codPagina'])) {
    $codPagina = sanitizarEntrada($_GET['codPagina']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM paginaweb LEFT JOIN conteudo ON paginaweb.codConteudo = conteudo.codConteudo WHERE paginaweb.codPagina = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codPagina]);

    if ($stmt->rowCount() > 0) {
        $paginaweb = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Editar Site</title>
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
            <form method="POST" action="processarEdicaoSite.php" enctype="multipart/form-data">
                <h1>Edição de Site</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codPagina" value="<?= $codPagina ?>">
                <input type="hidden" name="codConteudo" value="<?= $paginaweb['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $paginaweb['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $paginaweb['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $paginaweb['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $paginaweb['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
                <p>
                    <label for="linkPagina">Link:</label>
                    <input type="text" id="linkPagina" name="linkPagina" value="<?= $paginaweb['linkPagina'] ?>" required>
                </p>


                <p>
                    <label for="autorPagina"> Autor</label>
                    <input type="text" id="autorPagina" name="autorPagina" value="<?= $paginaweb['autorPagina'] ?>">
                </p>
                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
