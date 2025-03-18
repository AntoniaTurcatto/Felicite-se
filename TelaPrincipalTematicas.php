<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Emoções</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function excluirTematica(codTematica) {
            var confirmacao = confirm("Deseja realmente excluir esta Temática?");

            if (confirmacao) {
                // Crie um formulário dinamicamente
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'excluirTematica.php';

                // Crie um input para o código do livro
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'codTematica';
                input.value = codTematica;

                // Adicione o input ao formulário
                form.appendChild(input);

                // Adicione o formulário ao corpo do documento
                document.body.appendChild(form);

                // Envie o formulário
                form.submit();
            }
        }

        function editarTematica(codTematica) {
            // Crie uma URL com o código do livro para a página de edição
            var url = "editarTematica.php?codTematica=" + codTematica;

            // Redirecione a página atual para a URL de edição
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
        <a href="CadastroTematica.html"><button class="cadastro-botao">Cadastrar</button></a>
    </div>
    <div class="table-container">
        <table class="tabela-scroll">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Imagem</th>
                    <th>Ações</th> <!-- Nova coluna para botões de ação -->
                </tr>
            </thead>
            <tbody>
                <?php
                include "funcoes.php";
                $conexao = conectarPDO();

                $sql = "SELECT * from tematica ";

                $result = $conexao->query($sql);

                // Preencher a tabela com os dados do banco de dados
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $imagemBase64 = base64_encode($row["imagemTematica"]);

                        echo "<tr>
                        <td>" . $row["codTematica"] . "</td>
                        <td>" . $row["nomeTematica"] . "</td>
                        <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do Filme' style='width:65px;height:75px;'></td>
                        
                        <td>
                            <button class='editar-botao' id='alterar' onclick='editarEmocao(" . $row["codTematica"] . ")'></button>
                            <button class='excluir-botao' id='excluir' onclick='excluirSite(" . (isset($row["codTematica"]) ? htmlspecialchars($row["codTematica"]) : 0) . ", this)'></button>
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
</body>

</html>