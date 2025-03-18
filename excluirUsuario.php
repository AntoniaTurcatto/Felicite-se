<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codUsuario'])) {
    $codUsuario = $_POST['codUsuario'];

    $conexao = conectarPDO();

    try {
        $conexao->beginTransaction();

      

        // Excluir da tabela 'Usuario'
        $sqlUsuario = "DELETE FROM usuario WHERE codUsuario = :codUsuario";
        $stmtUsuario= $conexao->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':codUsuario', $codUsuario, PDO::PARAM_INT);
        $stmtUsuario->execute();



        $conexao->commit();

        // Redireciona para a página inicial após a exclusão
        header("Location: TelaPrincipalUsuarios.php");
        exit();
    } catch (PDOException $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalUsuarios.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
