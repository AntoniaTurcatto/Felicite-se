<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>

        function excluirUsuario(codUsuario) {
            var confirmacao = confirm("Deseja realmente excluir este Usuario?");

            if (confirmacao) {
                // Crie um formulário dinamicamente
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'excluirUsuario.php';

                // Crie um input para o código do livro
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'codUsuario';
                input.value = codUsuario;

                // Adicione o input ao formulário
                form.appendChild(input);

                // Adicione o formulário ao corpo do documento
                document.body.appendChild(form);

                // Envie o formulário
                form.submit();
            }
        }

        function editarUsuario(codUsuario) {
            // Crie uma URL com o código do livro para a página de edição
            var url = "editarUsuario.php?codUsuario=" + codUsuario;

            // Redirecione a página atual para a URL de edição
            window.location.href = url;
        }
    </script>

</head>


<div class="header-gim">
    <div>
        <div class="ifsul2">IFSul Campus Venâncio Aires</div>
    </div>
</div>
<div class="retornar-botao">
    <a href="MenuPrincipal.html">
        <button>
            <img src="imagem\icons8-abaixo-e-à-esquerda-100.png" alt="Ícone de retorno" class="icone-retorno">
        </button>
    </a>
</div>
<div class="div-botao">
    <a href="CadastroUsuarios.html"><button class="cadastro-botao">Cadastrar</button></a>
</div>


<div class="table-container">
    <table class="tabela-scroll">
        <thead>
            <tr>
                <th></th>
                <th>Nome</th>
                <th>Gênero</th>
                <th>Cargo:</th>
                <th>Email</th>        
                <th>Ações</th>
                <!-- Nova coluna para botões de ação -->
            </tr>
        </thead>
        <tbody>
            <?php
            include "funcoes.php";
            $conexao = conectarPDO();
            
            $sql = "SELECT * from usuario "; 
            
            $result = $conexao->query($sql);
            
            // Preencher a tabela com os dados do banco de dados
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    // Mapear valores numéricos para textos específicos
                    $genero = ($row["generoUsuario"] == 1) ? "Masculino" : "Feminino";
                    $cargo = ($row["tipoUsuario"] == 1) ? "Estudante" : "Servidor";
            
                    echo "<tr>
                        <td>" . $row["codUsuario"] . "</td>
                        <td>" . $row["nomeUsuario"] . "</td>
                        <td>" . $genero . "</td>
                        <td>" . $cargo . "</td>
                        <td>" . $row["emailUsuario"] . "</td>
                        
                        <td>
                            <button class='editar-botao' id='alterar' onclick='editarUsuario(" . $row["codUsuario"] . ")'></button>
                            <button class='excluir-botao' id='excluir' onclick='excluirUsuario(" . (isset($row["codUsuario"]) ? htmlspecialchars($row["codUsuario"]) : 0) . ", this)'></button>
                        </td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Nenhum dado encontrado</td></tr>";
            }
            ?>
            

        </tbody>
    </table>
</div>