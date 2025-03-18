<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}


// Função para alterar um usuário no banco de dados
function alterarEmocao($conexao, $codEmocao,$tipoEmocao,$dataEmocao)
{
    try {
        $sql = "UPDATE emocao SET tipoEmocao = ?, dataEmocao = ?";
        
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$conexao, $codEmocao,$tipoEmocao,$dataEmocao]);
        
        return true;
    } catch (PDOException $e) {
        // Trate o erro conforme necessário, por exemplo, log ou exiba uma mensagem de erro
        return false;
    }
}



// Inicializa as mensagens
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $codEmocao = sanitizarEntrada($_POST['codEmocao']);
    $tipoEmocao = sanitizarEntrada($_POST['tipoEmocao']);
    $dataEmocao = sanitizarEntrada($_POST['dataEmocao']);
  
    // Chame a função para alterar o usuário no banco de dados
    if (alterarEmocao($conexao, $codEmocao,$tipoEmocao,$dataEmocao)) {
        $mensagem = "Emoção alterada com sucesso!";
    } else {
        $mensagem = "Erro ao alterar a Emoção. Por favor, tente novamente.";
    }

    header("Location: TelaPrincipalEmocão.php");
    exit();
} elseif (isset($_GET['codEmocao'])) {
    $codEmocao = sanitizarEntrada($_GET['codEmocao']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM emocao";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codEmocao]);

    if ($stmt->rowCount() > 0) {
        $emocao = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: TelaPrincipalEmocão.php");
        exit();
    }
} else {
    header("Location: TelaPrincipalEmocão.php");
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
            <form method="POST" action="processarEdicaoEmocao.php">
                <h1>Edição de Emoções</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codEmocao" value="<?= $codEmocao ?>">
               

                <p>
                    <label for="tipoEmocao">Tipo Emoção:</label>
                    <input type="text" id="tipoEmocao" name="tipoEmocao" value="<?= $emocao['tipoEmocao'] ?>" required>
                </p>
                <p>
                    <label for="dataEmocao">Data Emoção:</label>
                    <input type="text" id="dataEmocao" name="dataEmocao" value="<?= $emocao['dataEmocao'] ?>" required>
                </p>
            
                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>
</body>

</html>