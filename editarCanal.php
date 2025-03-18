<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codCanal'])) {
    $codCanal = sanitizarEntrada($_GET['codCanal']); // Corrigido o nome da variável
    $conexao = conectarPDO();
    $sql = "SELECT * FROM canalyoutube LEFT JOIN conteudo ON canalyoutube.codConteudo = conteudo.codConteudo WHERE canalyoutube.codCanal = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codCanal]);

    if ($stmt->rowCount() > 0) {
        $canalyoutube = $stmt->fetch(PDO::FETCH_ASSOC); // Corrigido o nome da variável
    } else {
        header("Location: TelaPrincipalCanais.php"); // Corrigido o redirecionamento
        exit();
    }
} else {
    header("Location: TelaPrincipalCanais.php"); // Corrigido o redirecionamento
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Canal</title>
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
            <form method="POST" action="processarEdicaoCanal.php" enctype="multipart/form-data">
                <h1>Edição de Canais</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codCanal" value="<?= $codCanal ?>">
                <input type="hidden" name="codConteudo" value="<?= $canalyoutube['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $canalyoutube['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $canalyoutube['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $canalyoutube['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $canalyoutube['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>
                <p>
                    <label for="linkCanal">Link do Canal:</label>
                    <input type="text" id="linkCanal" name="linkCanal" value="<?= $canalyoutube['linkCanal'] ?>" required>
                </p>

                <p>
                    <label for="capaCanal">Capa do Canal:</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($canalyoutube['capaCanal']) ?>" alt="Capa do Canal" style="width: 100px; height: 100px;"><br>
                    <input type="file" id="novaCapaCanal" name="novaCapaCanal">
                </p>

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
