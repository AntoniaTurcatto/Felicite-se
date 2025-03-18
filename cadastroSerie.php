<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];
    $arquivo = $_FILES['arquivo_imagem'];
    $arquivo_blob = file_get_contents($arquivo['tmp_name']);
    $sinopseSerie = $_POST['sinopseSerie'];
    $temporadaSerie = $_POST['temporadaSerie'];
    $anoLancamentoSerie = $_POST['anoLancamentoSerie'];
    $plataformaSerie = $_POST['plataformaSerie'];
    
    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];
   
    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    // Verificar se o conteúdo foi cadastrado corretamente
    if ($ultimoIDConteudo) {
        // Função para cadastrar livro com o último ID de conteúdo
        inserirSeries($conexao, $arquivo_blob, $sinopseSerie, $temporadaSerie, $anoLancamentoSerie, $plataformaSerie, $ultimoIDConteudo);

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalSeries.php");
        exit();
    } else {
        // Tratar o caso em que o conteúdo não foi cadastrado
        echo "Erro ao cadastrar conteúdo.";
    }
   
}
?>