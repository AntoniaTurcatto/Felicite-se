<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $tipoEmocao = $_POST['tipoEmocao'];
    $dataEmocao = $_POST['dataEmocao'];
    
    

    inserirEmocoes($conexao, $tipoEmocao, $dataEmocao);

   
}
?>