<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Livros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <style>
        input[type="checkbox"] {
            margin-right: 5px;
            background-color: #c8a2c8;
            border: 1px solid #A6DFFA;
            border-radius: 3px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="header-gim">
        <div>
            <div class="ifsul2">IFSul Campus Venâncio Aires</div>
        </div>
    </div>

    <div class="container">
        <a class="links" id="paracadastro"></a>
        <a class="links" id="paralogin"></a>

        <div class="content">
            <div id="cadastro">
                <form method="post" action="cadastroLivro.php" enctype="multipart/form-data">
                    <h1>Cadastro de Livros</h1>

                    <!-- Campos de conteúdo -->
                    <p>
                        <label for="nomeConteudo">Nome</label>
                        <input id="nomeConteudo" name="nomeConteudo" required="required" type="text" placeholder="Nome do Conteúdo" />
                    </p>

                    <p>
                        <label for="descricaoConteudo">Descrição</label>
                        <input id="descricaoConteudo" name="descricaoConteudo" required="required" type="text" placeholder="Descrição do Conteúdo" />
                    </p>

                    <p>
                        <label for="descricaoIndicacao">Descrição de Indicação</label>
                        <input id="descricaoIndicacao" name="descricaoIndicacao" required="required" type="text" placeholder="Descrição de Indicação" />
                    </p>

                    <!-- Campos do livro -->
                    <p>
                        <label for="nomeEditora">Editora do Livro</label>
                        <input id="nomeEditora" name="nomeEditora" required="required" type="text" placeholder="Editora" />
                    </p>

                    <p>
                        <label for="capaLivro">Capa do livro</label>
                        <input type="file" name="arquivo_imagem" required="required" placeholder="Capa do livro">
                    </p>

                    <p>
                        <label for="autorLivro">Nome do autor</label>
                        <input id="autorLivro" name="autorLivro" required="required" type="text" placeholder="Nome do autor" />
                    </p>

                    <p>
                        <label for="anoLivro">Ano do livro</label>
                        <input id="anoLivro" name="anoLivro" required="required" type="text" placeholder="Ano do livro" />
                    </p>

                    <p>
                        <label for="paginasLivro">Quantidade de páginas do livro</label>
                        <input id="paginasLivro" name="paginasLivro" required="required" type="text" placeholder="Páginas do livro" />
                    </p>

                    <p>
                        <label for="generoLivro">Gênero do livro</label>
                        <input id="generoLivro" name="generoLivro" required="required" type="text" placeholder="Gênero do livro" />
                    </p>

                    <!-- Adição de checkboxes para Temáticas -->
                    <p>
                        <label for="tematicas">Temáticas</label>
                        <br>
                        <br>
                        <?php
                        include "funcoes.php";
                        $conexao = conectarPDO();
                        $queryTematica = "SELECT * FROM tematica";
                        $resultTematica = $conexao->query($queryTematica);
                        while ($rowTematica = $resultTematica->fetch(PDO::FETCH_ASSOC)) {
                            echo "<input type='checkbox' name='tematicas[]' value='" . $rowTematica['codTematica'] . "'>" . $rowTematica['nomeTematica'] . "<br>";
                        }
                        ?>
                    </p>

                    <p>
                        <input type="submit" value="Cadastrar" />
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        function validarFormulario() {
            var checkboxes = document.getElementsByName('tematicas[]');
            var peloMenosUmSelecionado = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    peloMenosUmSelecionado = true;
                    break;
                }
            }

            if (!peloMenosUmSelecionado) {
                alert('Selecione pelo menos uma temática.');
                return false;
            }

            return true;
        }
    </script>



</body>

</html>