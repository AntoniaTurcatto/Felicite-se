<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codArtigo'])) {
    $codArtigo = $_POST['codArtigo'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();


        $sqlConteudo = "SELECT codConteudo FROM artigo WHERE codArtigo = :codArtigo";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codArtigo', $codArtigo, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        $sqlLivro = "DELETE FROM artigo WHERE codArtigo = :codArtigo";
        $stmtLivro = $conexao->prepare($sqlLivro);
        $stmtLivro->bindParam(':codArtigo', $codArtigo, PDO::PARAM_INT);
        $stmtLivro->execute();

        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalArtigos.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalArtigos.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
