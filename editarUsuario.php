<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Função para alterar um usuário no banco de dados
function alterarUsuario($conexao, $codUsuario, $nome, $genero, $status, $email, $senha, $matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor)
{
    try {
        $sql = "UPDATE usuario 
                SET nomeUsuario = ?, generoUsuario = ?, tipoUsuario = ?, emailUsuario = ?, senhaUsuario = ?, matriculaEstudante = ?, matriculaServidor = ?, cargoServidor = ?, siapeServidor = ?
                WHERE codUsuario = ?";
        
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$nome, $genero, $status, $email, $senha, $matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor, $codUsuario]);
        
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
    $codUsuario = sanitizarEntrada($_POST['codUsuario']);
    $nome = sanitizarEntrada($_POST['nomeUsuario']);
    $genero = sanitizarEntrada($_POST['genero']);
    $status = sanitizarEntrada($_POST['status']);
    $email = sanitizarEntrada($_POST['emailUsuario']);
    $senha = sanitizarEntrada($_POST['senhaUsuario']);
    $matriculaEstudante = ($status === 'estudante') ? sanitizarEntrada($_POST['matriculaEstudante']) : null;
    $matriculaServidor = ($status === 'servidor') ? sanitizarEntrada($_POST['matriculaServidor']) : null;
    $cargoServidor = ($status === 'servidor') ? sanitizarEntrada($_POST['cargoServidor']) : null;
    $siapeServidor = ($status === 'servidor') ? sanitizarEntrada($_POST['siapeServidor']) : null;

    // Chame a função para alterar o usuário no banco de dados
    if (alterarUsuario($conexao, $codUsuario, $nome, $genero, $status, $email, $senha, $matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor)) {
        $mensagem = "Usuário alterado com sucesso!";
    } else {
        $mensagem = "Erro ao alterar o usuário. Por favor, tente novamente.";
    }

    header("Location: TelaPrincipalUsuarios.php");
    exit();
} elseif (isset($_GET['codUsuario'])) {
    $codUsuario = sanitizarEntrada($_GET['codUsuario']);

    $conexao = conectarPDO();
    $sql = "SELECT * FROM usuario WHERE codUsuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$codUsuario]);

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: TelaPrincipalUsuarios.php");
        exit();
    }
} else {
    header("Location: TelaPrincipalUsuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <style>
        .campo-desativado {
            background-color: #ccc; /* Cor de fundo cinza */
        }
    </style>
</head>

<body>
    <div class="header-gim">
        <div>
            <div class="ifsul2">IFSul Campus Venâncio Aires</div>
        </div>
    </div>
    <div class="content">
        <div id="cadastro">
            <form method="POST" action="" enctype="multipart/form-data">
                <h1>Edição de Site</h1>

                <!-- Exibição da mensagem -->
                <?php if (!empty($mensagem)) : ?>
                    <p class="<?php echo ($resultado) ? 'mensagem-sucesso' : 'mensagem-erro'; ?>"><?php echo $mensagem; ?></p>
                <?php endif; ?>
                <input type="hidden" name="codUsuario" value="<?= $codUsuario ?>">

                <p>
                    <label for="nomeUsuario">Link:</label>
                    <input type="text" id="nomeUsuario" name="nomeUsuario" value="<?= $usuario['nomeUsuario'] ?>" required>
                </p>

                <p>
                    <label>Seu gênero:</label>
                    <input type="radio" name="genero" value="masculino" <?= ($usuario['generoUsuario'] == 1) ? 'checked' : '' ?>> Masculino
                    <input type="radio" name="genero" value="feminino" <?= ($usuario['generoUsuario'] == 2) ? 'checked' : '' ?>> Feminino
                </p>

                <p>
                    <label>Você é:</label>
                    <input type="radio" name="status" value="estudante" <?= ($usuario['tipoUsuario'] == 1) ? 'checked' : '' ?> onchange="handleStatusChange()"> Estudante
                    <input type="radio" name="status" value="servidor" <?= ($usuario['tipoUsuario'] == 2) ? 'checked' : '' ?> onchange="handleStatusChange()"> Servidor
                </p>

                <p>
                    <label for="emailUsuario">E-mail:</label>
                    <input type="text" id="emailUsuario" name="emailUsuario" value="<?= $usuario['emailUsuario'] ?>" required>
                </p>

                <p>
                    <label for="senhaUsuario">Senha:</label>
                    <input type="text" id="senhaUsuario" name="senhaUsuario" value="<?= $usuario['senhaUsuario'] ?>" required>
                </p>

                <p>
                    <label for="matriculaEstudante">Matrícula do estudante:</label>
                    <input type="text" id="matriculaEstudante" name="matriculaEstudante" value="<?= $usuario['matriculaEstudante'] ?>" <?= ($usuario['tipoUsuario'] == 2) ? 'disabled class="campo-desativado"' : '' ?> required>
                </p>

                <p>
                    <label for="matriculaServidor">Matrícula do servidor:</label>
                    <input type="text" id="matriculaServidor" name="matriculaServidor" value="<?= $usuario['matriculaServidor'] ?>" <?= ($usuario['tipoUsuario'] == 1) ? 'disabled class="campo-desativado"' : '' ?> required>
                </p>

                <p>
                    <label for="cargoServidor">Cargo do servidor:</label>
                    <input type="text" id="cargoServidor" name="cargoServidor" value="<?= $usuario['cargoServidor'] ?>" <?= ($usuario['tipoUsuario'] == 1) ? 'disabled class="campo-desativado"' : '' ?> required>
                </p>

                <p>
                    <label for="siapeServidor">Siape do servidor:</label>
                    <input type="text" id="siapeServidor" name="siapeServidor" value="<?= $usuario['siapeServidor'] ?>" <?= ($usuario['tipoUsuario'] == 1) ? 'disabled class="campo-desativado"' : '' ?> required>
                </p>

                <p>
                    <input type="submit" value="Alterar" />
                </p>
            </form>
        </div>
    </div>

    <script>
        function handleStatusChange() {
            var status = document.querySelector('input[name="status"]:checked').value;
            var matriculaEstudante = document.getElementById('matriculaEstudante');
            var matriculaServidor = document.getElementById('matriculaServidor');
            var cargoServidor = document.getElementById('cargoServidor');
            var siapeServidor = document.getElementById('siapeServidor');

            if (status === 'estudante') {
                matriculaEstudante.removeAttribute('disabled');
                matriculaEstudante.classList.remove('campo-desativado');
                matriculaServidor.setAttribute('disabled', 'disabled');
                matriculaServidor.classList.add('campo-desativado');
                cargoServidor.setAttribute('disabled', 'disabled');
                cargoServidor.classList.add('campo-desativado');
                siapeServidor.setAttribute('disabled', 'disabled');
                siapeServidor.classList.add('campo-desativado');
            } else if (status === 'servidor') {
                matriculaEstudante.setAttribute('disabled', 'disabled');
                matriculaEstudante.classList.add('campo-desativado');
                matriculaServidor.removeAttribute('disabled');
                matriculaServidor.classList.remove('campo-desativado');
                cargoServidor.removeAttribute('disabled');
                cargoServidor.classList.remove('campo-desativado');
                siapeServidor.removeAttribute('disabled');
                siapeServidor.classList.remove('campo-desativado');
            }
        }
    </script>
</body>

</html>
