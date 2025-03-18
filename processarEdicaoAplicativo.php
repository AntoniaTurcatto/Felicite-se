<?php
include "funcoes.php";

// Função para sanitizar os dados de entrada
function sanitizarEntrada($dados)
{
    return htmlspecialchars(strip_tags(trim($dados)), ENT_QUOTES, 'UTF-8');
}

// Inicializa as mensagens
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $codAplicativo = sanitizarEntrada($_POST['codAplicativo']);
    $codConteudo = sanitizarEntrada($_POST['codConteudo']);
    $nomeConteudo = sanitizarEntrada($_POST['nomeConteudo']);
    $descricaoConteudo = sanitizarEntrada($_POST['descricaoConteudo']);
    $descricaoIndicacao = sanitizarEntrada($_POST['descricaoIndicacao']);
    $tematicaConteudo = sanitizarEntrada($_POST['tematicaConteudo']);
    $linkAplicativo = sanitizarEntrada($_POST['linkAplicativo']);
    $desenvolvedoresAplicativo = sanitizarEntrada($_POST['desenvolvedoresAplicativo']);
    $gratisAplicativo = sanitizarEntrada($_POST['gratisAplicativo']);

    // Conectar ao banco de dados
    $conexao = conectarPDO();

    // Atualizar os dados na tabela conteudo
    $sqlConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtConteudo = $conexao->prepare($sqlConteudo);
    $stmtConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Atualizar os dados na tabela aplicativo
    $sqlAplicativo = "UPDATE aplicativo SET linkAplicativo = ?, desenvolvedoresAplicativo = ?, gratisAplicativo = ? WHERE codAplicativo = ?";
    $stmtAplicativo = $conexao->prepare($sqlAplicativo);
    $stmtAplicativo->execute([$linkAplicativo, $desenvolvedoresAplicativo, $gratisAplicativo, $codAplicativo]);

    // Verificar se as atualizações foram bem-sucedidas
    if ($stmtConteudo && $stmtAplicativo) {
        $mensagem = "Edição realizada com sucesso!";
    } else {
        $mensagem = "Erro ao editar o aplicativo.";
    }


    // Redirecionar para a página de visualização após o processamento

    echo "Aplicativo Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalAplicativos.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
