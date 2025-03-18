<!DOCTYPE html>

<head>
  <meta charset="UTF-8" />
  <title>Cadastrar Série</title>
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
        <form method="post" action="cadastroSerie.php" enctype="multipart/form-data">
          <h1>Cadastro de Séries</h1>

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
          <!---
          <p>
            <label for="tematicaConteudo">Temática</label>
            <input id="tematicaConteudo" name="tematicaConteudo" required="required" type="text"
              placeholder="Temática do Conteúdo" />
          </p>
          -->
          <p>
            <label for="capaSerie">Capa da série</label>
            <input type="file" name="arquivo_imagem" required="required" placeholder="Capa da série" />
          </p>

          <p>
            <label for="sinopseSerie">Sinopse da série</label>
            <input id="sinopseSerie" name="sinopseSerie" required="required" type="text" placeholder="Sinopse da série">
          </p>

          <p>
            <label for="temporadaSerie">Temporada da série</label>
            <input id="temporadaSerie" name="temporadaSerie" required="required" type="text" placeholder="Temporada" />
          </p>

          <p>
            <label for="anoLancamentoSerie">Ano de lançamento</label>
            <input id="anoLancamentoSerie" name="anoLancamentoSerie" required="required" type="text"
              placeholder="Ano" />
          </p>

          <p>
            <label for="plataformaSerie">Plataforma</label>
            <input id="plataformaSerie" name="plataformaSerie" required="required" type="text"
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