<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codCanal'])) {
    $codCanal = $_POST['codCanal'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

        // Obter o código do conteúdo associado ao livro
        $sqlConteudo = "SELECT codConteudo FROM canalyoutube WHERE codCanal = :codCanal";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codCanal', $codCanal, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        // Excluir da tabela 'livro'
        $sqlCanal = "DELETE FROM canalyoutube WHERE codCanal = :codCanal";
        $stmtCanal = $conexao->prepare($sqlCanal);
        $stmtCanal->bindParam(':codCanal', $codCanal, PDO::PARAM_INT);
        $stmtCanal->execute();

        // Excluir da tabela 'conteudo'
        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalCanais.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalCanais.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
