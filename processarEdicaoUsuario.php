<?php
include "funcoes.php";

// Verifique se os parâmetros necessários foram fornecidos no POST
if (
  
    isset($_POST['codUsuario']) &&
    isset($_POST['nomeUsuario']) &&
    isset($_POST['generoUsuario']) &&
    isset($_POST['tipoUsuario'])
 
  
)
 {
    // Obtenha os dados do formulário
    $codUsuario = $_POST['codUsuario']; 
    $nomeUsuario = $_POST['nomeUsuario'];
    $generoUsuario = $_POST['generoUsuario'];
    $tipoUsuario = $_POST['tipoUsuario'];
   

    // Conecte-se ao banco de dados
    $conexao = conectarPDO();

    // Atualize os dados no banco de dados
    // Atualizar dados na tabela livro
    $sqlUpdateUsuario = "UPDATE usuario SET nomeUsuario = ?, generoUsuario = ?, tipoUsuario = ? WHERE codUsuario = ?";
    $stmtUpdateUsuario = $conexao->prepare($sqlUpdateUsuario);
    $stmtUpdateUsuario->execute([$nomeUsuario, $generoUsuario,$tipoUsuario ,$codUsuario]);

    // Redirecione para a página principal ou outra página após a atualização
    echo "Site Editado com sucesso!";
    header("refresh:1;url=TelaPrincipalUsuarios.php");
    exit();
} else {
    echo "Parâmetros não estão definidos corretamente.";
    exit();
}
