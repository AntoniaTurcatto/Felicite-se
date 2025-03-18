<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];
    $linkPagina = $_POST['linkPagina'];
    $autorPagina = $_POST['autorPagina'];


    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];

    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    // Verificar se o conteúdo foi cadastrado corretamente
    if ($ultimoIDConteudo) {
        // Função para cadastrar livro com o último ID de conteúdo
        inserirSites($conexao, $linkPagina, $autorPagina, $ultimoIDConteudo, $descricaoConteudo, $descricaoIndicacao, -1);

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalSites.php");
        exit();
    } else {
        // Tratar o caso em que o conteúdo não foi cadastrado
        echo "Erro ao cadastrar conteúdo.";
    }

    header("refresh:1;url=CadastroUsuarios.html");
    exit();
   
}


?>