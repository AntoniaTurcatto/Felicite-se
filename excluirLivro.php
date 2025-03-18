<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codLivro'])) {
    $codLivro = $_POST['codLivro'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

        // Obter o código do conteúdo associado ao livro
        $sqlConteudo = "SELECT codConteudo FROM livro WHERE codLivro = :codLivro";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codLivro', $codLivro, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        // Excluir da tabela 'livro'
        $sqlLivro = "DELETE FROM livro WHERE codLivro = :codLivro";
        $stmtLivro = $conexao->prepare($sqlLivro);
        $stmtLivro->bindParam(':codLivro', $codLivro, PDO::PARAM_INT);
        $stmtLivro->execute();

        // Excluir da tabela 'conteudo'
        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalLivros.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalLivros.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
