<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = conectarPDO();
    $nomeConteudo = $_POST['nomeConteudo'];
    $descricaoConteudo = $_POST['descricaoConteudo'];
    $descricaoIndicacao = $_POST['descricaoIndicacao'];
    //$tematicaConteudo = $_POST['tematicaConteudo'];
    $dataEvento = $_POST['dataEvento'];
    $localeventoEmocao = $_POST['localEvento'];
    $responsavelEvento = $_POST['responsavelEvento'];


    // Processar checkboxes das emoções
    $tematicasSelecionadas = isset($_POST['tematicas']) ? $_POST['tematicas'] : [];

    $ultimoIDConteudo = inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao);

    if($ultimoIDConteudo){
        inserirEventos($conexao, $dataEvento, $localeventoEmocao, $responsavelEvento, $ultimoIDConteudo);

        // Associar o conteúdo às temáticas selecionadas
        foreach ($tematicasSelecionadas as $codTematica) {
            // Função para cadastrar na tabela conteudoTematica
            cadastrarConteudoTematica($conexao, $ultimoIDConteudo, $codTematica);
        }

        header("refresh:1;url=TelaPrincipalEventos.php");
    } else{
        echo "Erro ao cadastrar o Evento.";
    }

}
?>