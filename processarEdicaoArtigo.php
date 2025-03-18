<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codArtigo']) &&
    isset($_POST['linkArtigo']) &&
    isset($_POST['resumoArtigo']) &&
    isset($_POST['anoPublicacao']) &&
    isset($_POST['autorArtigo'])
) {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codArtigo = $_POST['codArtigo'];
    $linkArtigo = $_POST['linkArtigo'];
    $resumoArtigo = $_POST['resumoArtigo'];
    $anoPublicacao = $_POST['anoPublicacao'];
    $autorArtigo = $_POST['autorArtigo'];

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateSerie = "UPDATE artigo SET linkArtigo = ?, resumoArtigo = ?, anoPublicacao = ?, autorArtigo = ?, codConteudo = ? WHERE codArtigo = ?";
    $stmtUpdateSerie = $conexao->prepare($sqlUpdateSerie);
    $stmtUpdateSerie->execute([$linkArtigo, $resumoArtigo, $anoPublicacao,  $autorArtigo, $codConteudo, $codArtigo]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Redirecione para a página principal ou outra página após a atualização
    echo "Artigo Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalArtigos.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
