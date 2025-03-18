<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codEvento'])) {
    $codEvento = $_POST['codEvento'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();


        $sqlConteudo = "SELECT codConteudo FROM evento WHERE codEvento = :codEvento";
        $stmtConteudo = $conexao->prepare($sqlConteudo);
        $stmtConteudo->bindParam(':codEvento', $codEvento, PDO::PARAM_INT);
        $stmtConteudo->execute();
        $codConteudo = $stmtConteudo->fetchColumn();

        $sqlLivro = "DELETE FROM evento WHERE codEvento = :codEvento";
        $stmtLivro = $conexao->prepare($sqlLivro);
        $stmtLivro->bindParam(':codEvento', $codEvento, PDO::PARAM_INT);
        $stmtLivro->execute();

        $sqlExcluirConteudo = "DELETE FROM conteudo WHERE codConteudo = :codConteudo";
        $stmtExcluirConteudo = $conexao->prepare($sqlExcluirConteudo);
        $stmtExcluirConteudo->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
        $stmtExcluirConteudo->execute();

        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalEventos.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalEventos.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
