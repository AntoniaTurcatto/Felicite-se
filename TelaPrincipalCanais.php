


<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Series</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function excluirCanal(codCanal) {
            var confirmacao = confirm("Deseja realmente excluir este Canal?");

            if (confirmacao) {
                // Crie um formulário dinamicamente
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'excluirCanal.php';

                // Crie um input para o código do livro
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'codCanal';
                input.value = codCanal;

                // Adicione o input ao formulário
                form.appendChild(input);

                // Adicione o formulário ao corpo do documento
                document.body.appendChild(form);

                // Envie o formulário
                form.submit();
            }
        }

        function editarCanal(codCanal) {
            // Crie uma URL com o código do livro para a página de edição
            var url = "editarCanal.php?codCanal=" + codCanal;

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
        <a href="CadastroCanaisUsuario.php"><button class="cadastro-botao">Cadastrar</button></a>
    </div>


    <div class="table-container">
        <table class="tabela-scroll">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome do Canal</th>
                    <th>Link do Canal</th>
                    <th>Capa do Canal</th>
                    <th>Ações</th>
                     <!-- Nova coluna para botões de ação -->
                </tr>
            </thead>
            <tbody>
                <?php
                include "funcoes.php";
                $conexao = conectarPDO();

                $sql = "SELECT l.*, c.nomeConteudo, c.aprovado FROM canalyoutube l
                    JOIN conteudo c ON l.codConteudo = c.codConteudo
                    WHERE c.aprovado = 1";
                $result = $conexao->query($sql);

                // Preencher a tabela com os dados do banco de dados
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        // Codificar a imagem em base64
                        $imagemBase64 = base64_encode($row["capaCanal"]);

                        echo "<tr>
            <td>" . $row["codCanal"] . "</td>                        
            <td>" . $row["nomeConteudo"] . "</td>
            <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do Canal' style='width:65px;height:75px;'></td>
            <td>" . $row["linkCanal"] . "</td>
          
            
            
            <td>
                <button class='editar-botao' id='alterar' onclick='editarCanal(" . $row["codCanal"] . ")'></button>
                <button class='excluir-botao' id='excluir' onclick='excluirCanal(" . (isset($row["codCanal"]) ? htmlspecialchars($row["codCanal"]) : 0) . ", this)'></button>
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