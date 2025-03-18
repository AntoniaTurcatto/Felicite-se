<?php
include "funcoes.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    $nomeEditora = $_POST['nomeEditora'];
    $arquivo = $_FILES['arquivo_imagem'];
    $arquivo_blob = file_get_contents($arquivo['tmp_name']);
    $autorLivro = $_POST['autorLivro'];
    $anoLivro = $_POST['anoLivro'];
    $paginasLivro = $_POST['paginasLivro'];
    $generoLivro = $_POST['generoLivro'];

    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];

    // Mensagens de depuração
    echo "Temáticas Selecionadas: " . implode(", ", $tematicasSelecionadas) . "<br>";

    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    // Verificar se o conteúdo foi cadastrado corretamente
    if ($ultimoIDConteudo) {
        // Função para cadastrar livro com o último ID de conteúdo
        $resultado = inserirLivros($conexao, $nomeEditora, $arquivo_blob, $autorLivro, $anoLivro, $paginasLivro, $generoLivro, $ultimoIDConteudo);
        echo $resultado;

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalLivros.php");
        exit();
    } else {
        // Tratar o caso em que o conteúdo não foi cadastrado
        echo "Erro ao cadastrar conteúdo.";
    }
}
?>
