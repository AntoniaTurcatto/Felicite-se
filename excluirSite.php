<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codPagina'])) {
    $codPagina = $_POST['codPagina'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

        // Obter o código do conteúdo associado ao paginaweb
        $sqlConteudo = "SELECT codConteudo FROM paginaweb WHERE codPagina = :codPagina";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codPagina', $codPagina, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        // Excluir da tabela 'paginaweb'
        $sqlpaginaweb = "DELETE FROM paginaweb WHERE codPagina = :codPagina";
        $stmtpaginaweb = $conexao->prepare($sqlpaginaweb);
        $stmtpaginaweb->bindParam(':codPagina', $codPagina, PDO::PARAM_INT);
        $stmtpaginaweb->execute();

        // Excluir da tabela 'conteudo'
        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalSites.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalSites.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
