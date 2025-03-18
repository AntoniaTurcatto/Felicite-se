<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codSerie']) &&
    isset($_FILES['novaCapaSerie'])&&
    isset($_POST['sinopseSerie']) &&
    isset($_POST['temporadaSerie']) &&
    isset($_POST['anoLancamentoSerie']) &&
    isset($_POST['plataformaSerie']) 
)
 {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codSerie = $_POST['codSerie']; 
    $sinopseSerie = $_POST['sinopseSerie'];
    $temporadaSerie = $_POST['temporadaSerie'];
    $anoLancamentoSerie = $_POST['anoLancamentoSerie'];
    $plataformaSerie = $_POST['plataformaSerie'];
   

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateSerie = "UPDATE serie SET sinopseSerie = ?, temporadaSerie = ?, anoLancamentoSerie = ?, plataformaSerie = ?, codConteudo = ? WHERE codSerie = ?";
    $stmtUpdateSerie = $conexao->prepare($sqlUpdateSerie);
    $stmtUpdateSerie->execute([$sinopseSerie, $temporadaSerie, $anoLancamentoSerie, $plataformaSerie, $codConteudo, $codSerie]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Lidar com a atualização da capa do livro, se houver um novo arquivo
    if ($_FILES['novaCapaSerie']['error'] == UPLOAD_ERR_OK) {
        $novaCapaSerie = file_get_contents($_FILES['novaCapaSerie']['tmp_name']);

        // Atualizar a capa do livro na tabela livro
        $sqlUpdateCapaSerie = "UPDATE serie SET capaSerie = ? WHERE codSerie = ?";
        $stmtUpdateCapaSerie = $conexao->prepare($sqlUpdateCapaSerie);
        $stmtUpdateCapaSerie->execute([$novaCapaSerie, $codSerie]);
    }

    // Redirecione para a página principal ou outra página após a atualização
    echo "Serie Editada com sucesso!";
    header("refresh:1;url=TelaPrincipalSeries.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
