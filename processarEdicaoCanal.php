<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codCanal']) &&
    isset($_POST['linkCanal']) &&
    isset($_FILES['novaCapaCanal'])
) {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codCanal = $_POST['codCanal'];
    $linkCanal = $_POST['linkCanal'];

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateSerie = "UPDATE canalyoutube SET linkCanal = ?, codConteudo = ? WHERE codCanal = ?";
    $stmtUpdateSerie = $conexao->prepare($sqlUpdateSerie);
    $stmtUpdateSerie->execute([$linkCanal,  $codConteudo, $codCanal]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Lidar com a atualização da capa do livro, se houver um novo arquivo
    if ($_FILES['novaCapaCanal']['error'] == UPLOAD_ERR_OK) {
        $novaCapaCanal = file_get_contents($_FILES['novaCapaCanal']['tmp_name']);

        // Atualizar a capa do livro na tabela livro
        $sqlUpdateCapaCanal = "UPDATE canalyoutube SET capaCanal = ? WHERE codCanal = ?";
        $stmtUpdateCapaCanal = $conexao->prepare($sqlUpdateCapaCanal);
        $stmtUpdateCapaCanal->execute([$novaCapaCanal, $codCanal]);
    }

    // Redirecione para a página principal ou outra página após a atualização
    echo "Site Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalCanais.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
