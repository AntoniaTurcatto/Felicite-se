<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codSerie'])) {
    $codSerie = $_POST['codSerie'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

        // Obter o código do conteúdo associado ao livro
        $sqlConteudo = "SELECT codConteudo FROM serie WHERE codSerie = :codSerie";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codSerie', $codSerie, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        // Excluir da tabela 'livro'
        $sqlSerie = "DELETE FROM serie WHERE codSerie = :codSerie";
        $stmtSerie = $conexao->prepare($sqlSerie);
        $stmtSerie->bindParam(':codSerie', $codSerie, PDO::PARAM_INT);
        $stmtSerie->execute();

        // Excluir da tabela 'conteudo'
        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalSeries.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalSeries.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
