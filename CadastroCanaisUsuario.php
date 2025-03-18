<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Canais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
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
                <form method="post" action="cadastroCanais.php" enctype="multipart/form-data">
                    <h1>Cadastro de Canais</h1>

                    <p>
                        <label for="nomeConteudo">Nome</label>
                        <input id="nomeConteudo" name="nomeConteudo" required="required" type="text"
                            placeholder="Nome do Conteúdo" />
                    </p>

                    <p>
                        <label for="descricaoConteudo">Descrição</label>
                        <input id="descricaoConteudo" name="descricaoConteudo" required="required" type="text"
                            placeholder="Descrição do Conteúdo" />
                    </p>

                    <p>
                        <label for="descricaoIndicacao">Descrição de Indicação</label>
                        <input id="descricaoIndicacao" name="descricaoIndicacao" required="required" type="text"
                            placeholder="Descrição de Indicação" />
                    </p>
                    <!--
                    <p>
                        <label for="tematicaConteudo">Temática</label>
                        <input id="tematicaConteudo" name="tematicaConteudo" required="required" type="text"
                            placeholder="Temática do Conteúdo" />
                    </p>
                    -->
                    <p>
                        <label for="linkCanal">Link do canal</label>
                        <input id="linkCanal" name="linkCanal" required="required" type="text" placeholder="Link" />
                    </p>

                    <p>
                        <label for="capaCanal">Capa do Canal</label>
                        <input type="file" name="arquivo_imagem" required="required" placeholder="Capa do Canal">
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
</body>

</html>
