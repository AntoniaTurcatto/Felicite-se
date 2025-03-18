<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];
    $linkArtigo = $_POST['linkArtigo'];
    $resumoArtigo = $_POST['resumoArtigo'];
    $anoPublicacao = $_POST['anoPublicacao'];
    $autorArtigo = $_POST['autorArtigo'];

    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];

    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    if ($ultimoIDConteudo) {
        inserirArtigo($conexao, $linkArtigo, $resumoArtigo, $anoPublicacao, $autorArtigo, $ultimoIDConteudo);

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalArtigos.php");
    } else {
        echo "Erro ao cadastrar o Artigo.";
    }
}
