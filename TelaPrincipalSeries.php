


<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Series</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function excluirSerie(codSerie) {
            var confirmacao = confirm("Deseja realmente excluir esta Serie?");

            if (confirmacao) {
                // Crie um formulário dinamicamente
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'excluirSerie.php';

                // Crie um input para o código do livro
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'codSerie';
                input.value = codSerie;

                // Adicione o input ao formulário
                form.appendChild(input);

                // Adicione o formulário ao corpo do documento
                document.body.appendChild(form);

                // Envie o formulário
                form.submit();
            }
        }

        function editarSerie(codSerie) {
            // Crie uma URL com o código do livro para a página de edição
            var url = "editarSerie.php?codSerie=" + codSerie;

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
        <a href="CadastroSeries.php"><button class="cadastro-botao">Cadastrar</button></a>
    </div>


    <div class="table-container">
        <table class="tabela-scroll">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Capa da Serie</th>
                    <th>Temporada</th>
                    <th>Ano</th>
                    <th>Plataforma</th>
                    <th>Ações</th>
                     <!-- Nova coluna para botões de ação -->
                </tr>
            </thead>
            <tbody>
                <?php
                include "funcoes.php";
                $conexao = conectarPDO();

                $sql = "SELECT l.*, c.nomeConteudo, c.aprovado FROM serie l
                    JOIN conteudo c ON l.codConteudo = c.codConteudo
                    WHERE c.aprovado = 1";
                $result = $conexao->query($sql);

                // Preencher a tabela com os dados do banco de dados
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        // Codificar a imagem em base64
                        $imagemBase64 = base64_encode($row["capaSerie"]);

        echo "<tr>
            <td>" . $row["codSerie"] . "</td>
            <td>" . $row["nomeConteudo"] . "</td>
            <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa da Serie' style='width:65px;height:75px;'></td>
            <td>" . $row["temporadaSerie"] . "</td>
            <td>" . $row["anoLancamentoSerie"] . "</td>
            <td>" . $row["plataformaSerie"] . "</td>
            
            <td>
                <button class='editar-botao' id='alterar' onclick='editarSerie(" . $row["codSerie"] . ")'></button>
                <button class='excluir-botao' id='excluir' onclick='excluirSerie(" . (isset($row["codSerie"]) ? htmlspecialchars($row["codSerie"]) : 0) . ", this)'></button>
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