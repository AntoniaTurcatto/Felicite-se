<?php
include "funcoes.php";
$conexao = conectarPDO();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $email = $_POST['emailUsuario'];
    $senha = $_POST['senhaUsuario'];

    $data = getSenhaDeAdmin($conexao, $email);
    if($data){
        $senhaBanco = $data['senhaUsuario'];

        //echo password_hash($senha, PASSWORD_ARGON2ID);

        if(password_verify($senha, $senhaBanco)){
            echo "<body id='body'> 
                <script>
                    alert('Login bem-sucedido!');
                    window.location.href = 'MenuPrincipal.html'; // Página de destino após login
                </script>
            </body>";
            exit();
        } else {
            echo "<script>
                alert('Administrador não encontrado/dados inválidos');
                history.back();
            </script>";
            exit();
        }

    } else {
    echo "<script>
        alert('Administrador não encontrado/dados inválidos');
        history.back();
    </script>";
    exit();
    }
}
?>