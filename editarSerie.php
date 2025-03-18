<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codSerie'])) {
    $codSerie = sanitizarEntrada($_GET['codSerie']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM serie LEFT JOIN conteudo ON serie.codConteudo = conteudo.codConteudo WHERE serie.codSerie = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codSerie]);

    if ($stmt->rowCount() > 0) {
        $serie = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Editar Serie</title>
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
            <form method="POST" action="processarEdicaoSerie.php" enctype="multipart/form-data">
                <h1>Edição de Serie</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codSerie" value="<?= $codSerie ?>">
                <input type="hidden" name="codConteudo" value="<?= $serie['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $serie['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $serie['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $serie['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $serie['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
                <p>
                    <label for="capaLivro">Capa da Serie:</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($serie['capaSerie']) ?>" alt="Capa da Serie" style="width: 100px; height: 100px;"><br>
                    <input type="file" id="novaCapaSerie" name="novaCapaSerie">
                </p>

                <p>
                    <label for="sinopseSerie">Sinopse:</label>
                    <input type="text" id="sinopseSerie" name="sinopseSerie" value="<?= $serie['sinopseSerie'] ?>">
                </p>

                <p>
                    <label for="temporadaSerie">Temporada:</label>
                    <input type="text" id="temporadaSerie" name="temporadaSerie" value="<?= $serie['temporadaSerie'] ?>">
                </p>

                <p>
                    <label for="anoLancamentoSerie">ano:</label>
                    <input type="text" id="anoLancamentoSerie" name="anoLancamentoSerie" value="<?= $serie['anoLancamentoSerie'] ?>">
                </p>

                <p>
                    <label for="plataformaSerie">Plataforma:</label>
                    <input type="text" id="plataformaSerie" name="plataformaSerie" value="<?= $serie['plataformaSerie'] ?>">
                </p>

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
