<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codAplicativo'])) {
    $codAplicativo = sanitizarEntrada($_GET['codAplicativo']); // Corrigido o nome da variável
    $conexao = conectarPDO();
    $sql = "SELECT * FROM aplicativo LEFT JOIN conteudo ON aplicativo.codConteudo = conteudo.codConteudo WHERE aplicativo.codAplicativo = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codAplicativo]);

    if ($stmt->rowCount() > 0) {
        $aplicativo = $stmt->fetch(PDO::FETCH_ASSOC); // Corrigido o nome da variável
    } else {
        header("Location: TelaPrincipalAplicativos.php"); // Corrigido o redirecionamento
        exit();
    }
} else {
    header("Location: TelaPrincipalAplicativos.php"); // Corrigido o redirecionamento
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artigos</title>
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
            <form method="POST" action="processarEdicaoAplicativo.php" enctype="multipart/form-data">
                <h1>Edição de Artigos</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codAplicativo" value="<?= $codAplicativo ?>">
                <input type="hidden" name="codConteudo" value="<?= $aplicativo['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" type="text" placeholder="Nome" value="<?= $aplicativo['nomeConteudo'] ?>" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $aplicativo['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $aplicativo['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $aplicativo['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>

                <p>
                    <label for="logoAplicativo">Logo do Aplicativo:</label>
                    <img src="data:image/jpeg;base64,<?= base64_encode($aplicativo['logoAplicativo']) ?>" alt="Logo do Aplicativo" style="width: 100px; height: 100px;"><br>
                    <input type="file" id="novologoAplicativo" name="novologoAplicativo">
                </p>

                <p>
                    <label for="linkAplicativo">Link do Aplicativo:</label>
                    <input id="linkAplicativo" name="linkAplicativo" value="<?= $aplicativo['linkAplicativo'] ?>" required>
                </p>

                <p>
                    <label for="desenvolvedoresAplicativo">Desenvolvedores do Aplicativo:</label>
                    <input id="desenvolvedoresAplicativo" name="desenvolvedoresAplicativo" value="<?= $aplicativo['desenvolvedoresAplicativo'] ?>" required="required" type="text" placeholder="Desenvolvedores" />
                </p>

                <p>
                    <label id="gratisAplicativo" for="gratisAplicativo">O aplicativo é grátis?</label>
                    <br>
                    <input type="radio" name="gratisAplicativo" value="1" <?php echo ($aplicativo['gratisAplicativo'] == 1) ? 'checked' : ''; ?> /> Sim
                    <input type="radio" name="gratisAplicativo" value="0" <?php echo ($aplicativo['gratisAplicativo'] == 0) ? 'checked' : ''; ?> /> Não
                </p>
                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>