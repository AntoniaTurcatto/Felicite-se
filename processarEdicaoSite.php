<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codPagina']) &&
    isset($_POST['linkPagina']) &&
    isset($_POST['autorPagina']) 
  
)
 {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codPagina = $_POST['codPagina']; 
    $linkPagina = $_POST['linkPagina'];
    $autorPagina = $_POST['autorPagina'];
    
   

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateSerie = "UPDATE paginaweb SET linkPagina = ?, autorPagina = ?, codConteudo = ? WHERE codPagina = ?";
    $stmtUpdateSerie = $conexao->prepare($sqlUpdateSerie);
    $stmtUpdateSerie->execute([$linkPagina, $autorPagina, $codConteudo, $codPagina]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);



    // Redirecione para a página principal ou outra página após a atualização
    echo "Site Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalSites.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
