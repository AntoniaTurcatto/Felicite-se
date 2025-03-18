<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codFilme'])) {
    $codFilme = sanitizarEntrada($_GET['codFilme']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM filme LEFT JOIN conteudo ON filme.codConteudo = conteudo.codConteudo WHERE filme.codFilme = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codFilme]);

    if ($stmt->rowCount() > 0) {
        $filme = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Editar Filme</title>
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
            <form method="POST" action="processarEdicaoFilme.php" enctype="multipart/form-data">
                <h1>Edição de Filmes</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codFilme" value="<?= $codFilme ?>">
                <input type="hidden" name="codConteudo" value="<?= $filme['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $filme['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $filme['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $filme['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $filme['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
               

                <p>
                    <label for="capaFilme">Capa do Filme:</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($filme['capaFilme']) ?>" alt="Capa do Filme" style="width: 100px; height: 100px;"><br>
                    <input type="file" id="novaCapaFilme" name="novaCapaFilme">
                </p>
                    
                <p>
                    <label for="sinopseFilme">Sinopse do Filme:</label>
                    <input type="text" id="sinopseFilme" name="sinopseFilme" value="<?= $filme['sinopseFilme'] ?>">
                </p>
                <p>
                    <label for="duracaoFilme">Duração do Filme:</label>
                    <input type="text" id="duracaoFilme" name="duracaoFilme" value="<?= $filme['duracaoFilme'] ?>">
                </p>

                <p>
                    <label for="anoLancamentoFilme">Ano Lançamento do Filme:</label>
                    <input type="text" id="anoLancamentoFilme" name="anoLancamentoFilme" value="<?= $filme['anoLancamentoFilme'] ?>">
                </p>

                <p>
                    <label for="plataformaFilme">Plataforma:</label>
                    <input type="text" id="plataformaFilme" name="plataformaFilme" value="<?= $filme['plataformaFilme'] ?>">
                </p>

            

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
