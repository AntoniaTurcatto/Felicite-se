<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
  
    isset($_POST['codEmocao']) &&
    isset($_POST['tipoEmocao']) &&
    isset($_POST['dataEmocao']) &&
    isset($_POST['tipoUsuario'])
 
  
)
 {
    // Obtenha os dados do formulário
    $codUscodEmocaouario = $_POST['codEmocao']; 
    $tipoEmocao = $_POST['tipoEmocao'];
    $dataEmocao = $_POST['dataEmocao'];

   

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateUsuario = "UPDATE emocao SET tipoEmocao = ?, dataEmocao = ?";
    $stmtUpdateUsuario = $conexao->prepare($sqlUpdateUsuario);
    $stmtUpdateUsuario->execute([$tipoEmocao, $dataEmocao,$codEmocao]);

    // Redirecione para a página principal ou outra página após a atualização
    echo "Emoção Editada com sucesso!";
    header("refresh:1;url=TelaPrincipalEmocao.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}