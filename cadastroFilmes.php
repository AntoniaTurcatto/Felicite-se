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
    $sinopseFilme = $_POST['sinopseFilme'];
    $duracaoFilme = $_POST['duracaoFilme'];
    $anoLancamentoFilme = $_POST['anoLancamentoFilme'];
    $plataformaFilme = $_POST['plataformaFilme'];


    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];


    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    // Verificar se o conteúdo foi cadastrado corretamente
    if ($ultimoIDConteudo) {
        // Função para cadastrar livro com o último ID de conteúdo
        $resultado = inserirFilme($conexao, $arquivo_blob, $sinopseFilme, $duracaoFilme, $anoLancamentoFilme, $plataformaFilme, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $ultimoIDConteudo);
        echo $resultado;

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            echo $ultimoIDConteudo;
            echo ", temática: " . $codTematica . "<br>";
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalFilmes.php");
        exit();
    } else {
        // Tratar o caso em que o conteúdo não foi cadastrado
        echo "Erro ao cadastrar conteúdo.";
    }
}
