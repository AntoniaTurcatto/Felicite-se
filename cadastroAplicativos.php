<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();

    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];

    if (isset($_FILES['logoAplicativo']) && $_FILES['logoAplicativo']['error'] === UPLOAD_ERR_OK) {
        $arquivo = $_FILES['logoAplicativo'];
        $arquivo_blob = file_get_contents($arquivo['tmp_name']);
    } else {
        echo "Erro no upload do arquivo.";
        exit();
    }

    $linkAplicativo = $_POST['linkAplicativo'];
    $desenvolvedoresAplicativo = $_POST['desenvolvedoresAplicativo'];
    $gratisAplicativo = $_POST['gratisAplicativo'];


    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];

    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    if ($ultimoIDConteudo) {
        $resultado = inserirAplicativo($conexao, $arquivo_blob, $linkAplicativo, $desenvolvedoresAplicativo, $gratisAplicativo, $ultimoIDConteudo);

        echo $resultado;

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalAplicativos.php");
        exit();
    } else {
        echo "Erro ao cadastrar conteúdo.";
    }
}
?>
