<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Aplicativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function excluirAplicativo(codAplicativo) {
            var confirmacao = confirm("Deseja realmente excluir este Aplicativo?");

            if (confirmacao) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'excluirAplicativo.php';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'codAplicativo';
                input.value = codAplicativo;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editarAplicativo(codAplicativo) {
            var url = "editarAplicativo.php?codAplicativo=" + codAplicativo;
            window.location.href = url;
        }
    </script>

</head>

<body>
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
        <a href="CadastroAplicativosUsuario.php"><button class="cadastro-botao">Cadastrar</button></a>
    </div>
    <div class="table-container">
        <table class="tabela-scroll">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Logo</th>
                    <th>Link do Aplicativo</th>
                    <th>Desenvolvedores</th>
                    <th>Gratuito</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "funcoes.php";
                $conexao = conectarPDO();

                $sql = "SELECT l.*, c.nomeConteudo, c.aprovado FROM aplicativo l
                        JOIN conteudo c ON l.codConteudo = c.codConteudo
                        WHERE c.aprovado = 1";
                $result = $conexao->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $imagemBase64 = base64_encode($row["logoAplicativo"]);

                        echo "<tr>
                                <td>" . $row["codAplicativo"] . "</td>
                                <td>" . $row["nomeConteudo"] . "</td>
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Logo do Aplicativo' style='width:65px;height:75px;'></td>
                                <td>" . $row["linkAplicativo"] . "</td>
                                <td>" . $row["desenvolvedoresAplicativo"] . "</td>
                                <td>" . ($row["gratisAplicativo"] == 1 ? "Sim" : "Não") . "</td>
                                <td>
                                    <button class='editar-botao' id='alterar' onclick='editarAplicativo(" . $row["codAplicativo"] . ")'></button>
                                    <button class='excluir-botao' id='excluir' onclick='excluirAplicativo(" . $row["codAplicativo"] . ")'></button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum dado encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>