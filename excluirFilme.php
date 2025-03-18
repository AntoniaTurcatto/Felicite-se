<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codFilme'])) {
    $codFilme = $_POST['codFilme'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

        // Obter o código do conteúdo associado ao livro
        $sqlConteudo = "SELECT codConteudo FROM filme WHERE codFilme = :codFilme";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codFilme', $codFilme, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        // Excluir da tabela 'livro'
        $sqlFilme = "DELETE FROM filme WHERE codFilme = :codFilme";
        $stmtFilme = $conexao->prepare($sqlFilme);
        $stmtFilme->bindParam(':codFilme', $codFilme, PDO::PARAM_INT);
        $stmtFilme->execute();

        // Excluir da tabela 'conteudo'
        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalFilmes.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalFilmes.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
