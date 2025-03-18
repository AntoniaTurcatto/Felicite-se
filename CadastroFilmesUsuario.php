<!DOCTYPE html>

<head>
  <meta charset="UTF-8" />
  <title>Cadastrar Filmes</title>
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
        <form method="post" action="cadastroFilmes.php" enctype="multipart/form-data">

          <h1>Cadastro de Filmes</h1>

          <p>
            <label for="nomeConteudo">Nome</label>
            <input id="nomeConteudo" name="nomeConteudo" required="required" type="text" placeholder="Nome" />
          </p>

          <p>
            <label for="descricaoConteudo">Descrição</label>
            <input id="descricaoConteudo" name="descricaoConteudo" required="required" type="text"
              placeholder="Descrição" />
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
              placeholder="Temática" />
          </p>
          -->

          <p> 
            <label for="capaFilme">Capa do filme</label>
            <input type="file" name="arquivo_imagem" required="required" placeholder="Capa do Filme">
         </p>
         


          <p>
            <label for="sinopseFilme">Sinopse do filme</label>
            <input id="sinopseFilme" name="sinopseFilme" required="required" type="text" placeholder="Sinopse do filme">
          </p>

          <p>
            <label for="duracaoFilme">Duração do filme</label>
            <input id="duracaoFilme" name="duracaoFilme" required="required" type="text" placeholder="Duração" />
          </p>

          <p>
            <label for="anoLancamentoFilme">Ano de lançamento</label>
            <input id="anoLancamentoFilme" name="anoLancamentoFilme" required="required" type="text"
              placeholder="Ano" />
          </p>

          <p>
            <label for="plataformaFilme">Plataforma</label>
            <input id="plataformaFilme" name="plataformaFilme" required="required" type="text"
              placeholder="Plataforma" />
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