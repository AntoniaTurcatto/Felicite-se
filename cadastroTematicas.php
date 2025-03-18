<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeTematica = $_POST['nomeConteudo'];
    $descricaoTematica = $_POST['descricaoConteudo'];
    $arquivo = $_FILES['arquivo_imagem'];
    $arquivo_blob = file_get_contents($arquivo['tmp_name']);
    

    inserirTematica($conexao, $nomeTematica, $descricaoTematica, $arquivo_blob);
    header("refresh:1;url=TelaPrincipalTematicas.php");
   
}
?>