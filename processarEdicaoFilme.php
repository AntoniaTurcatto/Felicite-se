<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codFilme']) &&
    isset($_POST['sinopseFilme']) &&
    isset($_FILES['novaCapaFilme']) &&
    isset($_POST['duracaoFilme']) &&
    isset($_POST['anoLancamentoFilme']) &&
    isset($_POST['plataformaFilme'])
) {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codFilme = $_POST['codFilme'];
    $sinopseFilme = $_POST['sinopseFilme'];
    $duracaoFilme = $_POST['duracaoFilme'];
    $anoLancamentoFilme = $_POST['anoLancamentoFilme'];
    $plataformaFilme = $_POST['plataformaFilme'];

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela filme
    $sqlUpdateFilme = "UPDATE filme SET sinopseFilme = ?, duracaoFilme = ?, anoLancamentoFilme = ?, plataformaFilme = ?, codConteudo = ? WHERE codFilme = ?";
    $stmtUpdateFilme = $conexao->prepare($sqlUpdateFilme);
    $stmtUpdateFilme->execute([$sinopseFilme, $duracaoFilme, $anoLancamentoFilme, $plataformaFilme, $codConteudo, $codFilme]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Lidar com a atualização da capa do filme, se houver um novo arquivo
    if ($_FILES['novaCapaFilme']['error'] == UPLOAD_ERR_OK) {
        $novaCapaFilme = file_get_contents($_FILES['novaCapaFilme']['tmp_name']);

        // Atualizar a capa do filme na tabela filme
        $sqlUpdateCapaFilme = "UPDATE filme SET capaFilme = ? WHERE codFilme = ?";
        $stmtUpdateCapaFilme = $conexao->prepare($sqlUpdateCapaFilme);
        $stmtUpdateCapaFilme->execute([$novaCapaFilme, $codFilme]);
    }

    // Redirecione para a página principal ou outra página após a atualização
    echo "Filme Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalFilmes.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
?>
