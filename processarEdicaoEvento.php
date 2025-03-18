<?php
include "funcoes.php";

// Inicializa as mensagens
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifique se os parâmetros necessários foram fornecidos no POST
    if (
        isset($_POST['codConteudo']) &&
        isset($_POST['nomeConteudo']) &&
        isset($_POST['descricaoConteudo']) &&
        isset($_POST['descricaoIndicacao']) &&
        isset($_POST['tematicaConteudo']) &&
        isset($_POST['codEvento']) &&
        isset($_POST['dataEvento']) &&
        isset($_POST['localEvento']) &&
        isset($_POST['responsavelEvento'])
    ) {
        // Obtenha os dados do formulário
        $codConteudo = $_POST['codConteudo'];
        $nomeConteudo = $_POST['nomeConteudo'];
        $descricaoConteudo = $_POST['descricaoConteudo'];
        $descricaoIndicacao = $_POST['descricaoIndicacao'];
        $tematicaConteudo = $_POST['tematicaConteudo'];
        $codEvento = $_POST['codEvento'];
        $dataEvento = $_POST['dataEvento'];
        $localEvento = $_POST['localEvento'];
        $responsavelEvento = $_POST['responsavelEvento'];

        // Conecte-se ao banco de dados
        $conexao = conectarPDO();

        // Atualizar dados na tabela evento
        $sqlUpdateEvento = "UPDATE evento SET dataEvento = ?, localEvento = ?, responsavelEvento = ?, codConteudo = ? WHERE codEvento = ?";
        $stmtUpdateEvento = $conexao->prepare($sqlUpdateEvento);
        $resultadoUpdateEvento = $stmtUpdateEvento->execute([$dataEvento, $localEvento, $responsavelEvento, $codConteudo, $codEvento]);

        // Atualizar dados na tabela conteudo
        $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
        $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
        $resultadoUpdateConteudo = $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

        // Verificar o resultado das atualizações
        if ($resultadoUpdateEvento && $resultadoUpdateConteudo) {
            echo "Evento Editada com sucesso!";
            header("refresh:1;url=TelaPrincipalEventos.php");
            exit();
        } else {
            $mensagem = "Erro ao editar o evento.";
        }
    } else {
        $mensagem = "Parâmetros não estão definidos corretamente.";
    }
}

// Restante do código permanece inalterado
?>
