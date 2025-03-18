<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codAplicativo'])) {
    $codAplicativo = $_POST['codAplicativo'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();


        $sqlConteudo = "SELECT codConteudo FROM aplicativo WHERE codAplicativo = :codAplicativo";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codAplicativo', $codAplicativo, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        $sqlLivro = "DELETE FROM aplicativo WHERE codAplicativo = :codAplicativo";
        $stmtLivro = $conexao->prepare($sqlLivro);
        $stmtLivro->bindParam(':codAplicativo', $codAplicativo, PDO::PARAM_INT);
        $stmtLivro->execute();

        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalAplicativos.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalAplicativos.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
