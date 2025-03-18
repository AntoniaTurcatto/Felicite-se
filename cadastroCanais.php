<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];
    $linkCanal = $_POST['linkCanal'];
    $arquivo = $_FILES['arquivo_imagem']; // Corrigido o nome do campo do formulário
    $arquivo_blob = file_get_contents($arquivo['tmp_name']);

    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];


    // Função para cadastrar conteúdo e obter o último ID inserido
    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    // Verificar se o conteúdo foi cadastrado corretamente
    if ($ultimoIDConteudo) {
        // Função para cadastrar canal do Youtube com o último ID de conteúdo
        inserirCanalYoutube($conexao, $linkCanal, $arquivo_blob, $ultimoIDConteudo);

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalCanais.php");
        exit();
    } else {
        // Tratar o caso em que o conteúdo não foi cadastrado
        echo "Erro ao cadastrar conteúdo.";
    }
}
