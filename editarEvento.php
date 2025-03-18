<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if (isset($_GET['codEvento'])) {
    $codEvento = sanitizarEntrada($_GET['codEvento']);
    if (empty($codEvento)) {
        header("Location: TelaPrincipalEventos.php");
        exit();
    }

    $conexao = conectarPDO();
    $sql = "SELECT * FROM evento LEFT JOIN conteudo ON evento.codConteudo = conteudo.codConteudo WHERE evento.codEvento = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codEvento]);

    if ($stmt->rowCount() > 0) {
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: TelaPrincipalEventos.php");
        exit();
    }
} else {
    header("Location: TelaPrincipalEventos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
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
            <form method="POST" action="processarEdicaoEvento.php">
                <h1>Edição de Eventos</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codEvento" value="<?= $codEvento ?>">
                <input type="hidden" name="codConteudo" value="<?= $evento['codConteudo'] ?>">

                <p>
                    <label for="nomeConteudo">Nome</label>
                    <input id="nomeConteudo" name="nomeConteudo" required="required" value="<?= $evento['nomeConteudo'] ?>" type="text" placeholder="Nome do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoConteudo">Descrição</label>
                    <input id="descricaoConteudo" name="descricaoConteudo" value="<?= $evento['descricaoConteudo'] ?>" required="required" type="text" placeholder="Descrição do Conteúdo" />
                </p>

                <p>
                    <label for="descricaoIndicacao">Descrição de Indicação</label>
                    <input id="descricaoIndicacao" name="descricaoIndicacao" value="<?= $evento['descricaoIndicacao'] ?>" required="required" type="text" placeholder="Descrição de Indicação" />
                </p>

                <p>
                    <label for="tematicaConteudo">Temática</label>
                    <input id="tematicaConteudo" name="tematicaConteudo" value="<?= $evento['tematicaConteudo'] ?>" required="required" type="text" placeholder="Temática" />
                </p>

                <p>
                    <label for="dataEvento">Data do evento</label>
                    <input type="text" id="dataEvento" name="dataEvento" value="<?= $evento['dataEvento'] ?>" required>
                </p>

                <p>
                    <label for="localEvento">Local do evento</label>
                    <input type="text" id="localEvento" name="localEvento" value="<?= $evento['localEvento'] ?>" required>
                </p>

                <p>
                    <label for="responsavelEvento">Organizadores do evento</label>
                    <input type="text" id="responsavelEvento" name="responsavelEvento" value="<?= $evento['responsavelEvento'] ?>" required>
                </p>

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>
