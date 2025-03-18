<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nome = $_POST['nomeUsuario'];
    $genero = $_POST['genero'];
    $generoInt = ($genero === 'masculino') ? 0 : 1;
    $tipo = $_POST['status'];
    $tipoInt = ($tipo === 'estudante') ? 0 : (($tipo === 'servidor')? 1 : 2); //2=admin
    $email = $_POST['emailUsuario'];
    $senha = password_hash($_POST['senhaUsuario'], PASSWORD_ARGON2ID);
    $matriculaEstudante = ($tipo === 'estudante') ? $_POST['matriculaEstudante'] : null;
    $matriculaServidor = ($tipo === 'servidor') ? $_POST['matriculaServidor'] : null;
    $cargoServidor = ($tipo === 'servidor') ? $_POST['cargoServidor'] : null;
    $siapeServidor = ($tipo === 'servidor') ? $_POST['siapeServidor'] : null;

    inserirUsuario($conexao, $nome, $generoInt, $tipoInt, $email, $senha, $matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor);

    header("refresh:1;url=TelaPrincipalUsuarios.php");
    exit();
}



?>
