<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
    isset($_POST['codConteudo']) &&
    isset($_POST['nomeConteudo']) &&
    isset($_POST['descricaoConteudo']) &&
    isset($_POST['descricaoIndicacao']) &&
    isset($_POST['tematicaConteudo']) &&
    isset($_POST['codLivro']) &&
    isset($_POST['editoraLivro']) &&
    isset($_FILES['novaCapaLivro']) &&
    isset($_POST['anoLivro']) &&
    isset($_POST['paginasLivro']) &&
    isset($_POST['autorLivro']) &&
    isset($_POST['generoLivro'])
) {
    // Obtenha os dados do formulário
    $codConteudo = $_POST['codConteudo'];
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $tematicaConteudo = $_POST['tematicaConteudo'];
    $codLivro = $_POST['codLivro'];
    $editoraLivro = $_POST['editoraLivro'];
    $anoLivro = $_POST['anoLivro'];
    $paginasLivro = $_POST['paginasLivro'];
    $autorLivro = $_POST['autorLivro'];
    $generoLivro = $_POST['generoLivro'];

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateLivro = "UPDATE livro SET editoraLivro = ?, anoLivro = ?, paginasLivro = ?, autorLivro = ?, generoLivro = ?, codConteudo = ? WHERE codLivro = ?";
    $stmtUpdateLivro = $conexao->prepare($sqlUpdateLivro);
    $stmtUpdateLivro->execute([$editoraLivro, $anoLivro, $paginasLivro, $autorLivro, $generoLivro, $codConteudo, $codLivro]);

    // Atualizar dados na tabela conteudo
    $sqlUpdateConteudo = "UPDATE conteudo SET nomeConteudo = ?, descricaoConteudo = ?, descricaoIndicacao = ?, tematicaConteudo = ? WHERE codConteudo = ?";
    $stmtUpdateConteudo = $conexao->prepare($sqlUpdateConteudo);
    $stmtUpdateConteudo->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo, $codConteudo]);

    // Lidar com a atualização da capa do livro, se houver um novo arquivo
    if ($_FILES['novaCapaLivro']['error'] == UPLOAD_ERR_OK) {
        $novaCapaLivro = file_get_contents($_FILES['novaCapaLivro']['tmp_name']);

        // Atualizar a capa do livro na tabela livro
        $sqlUpdateCapaLivro = "UPDATE livro SET capaLivro = ? WHERE codLivro = ?";
        $stmtUpdateCapaLivro = $conexao->prepare($sqlUpdateCapaLivro);
        $stmtUpdateCapaLivro->execute([$novaCapaLivro, $codLivro]);
    }

    // Redirecione para a página principal ou outra página após a atualização
    echo "Livro Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalLivros.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
