<?php
include "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['arrayIdsSelecionados'])) {
    // Decodifica o JSON em um array PHP bidimensional
    $arrayIdsSelecionados = json_decode($_POST['arrayIdsSelecionados'], true);
    echo '<pre>';
    var_dump($arrayIdsSelecionados); // Aqui você verá: [["38", "livro"]]
    echo '</pre>';

    $conexao = conectarPDO();
    if ($arrayIdsSelecionados === null) {
        // Se a decodificação falhar, exibe um erro
        echo "Erro ao decodificar os dados JSON.";
        exit();
    }

    echo '<pre>';
    var_dump($arrayIdsSelecionados); // Verifica o array decodificado
    echo '</pre>';
    try {
        $conexao->beginTransaction();

        $sqlAprovarConteudo = "UPDATE conteudo SET aprovado = 1 WHERE codConteudo IN (";
        // Cria um array de parâmetros para os ids
        $params = [];

        // Preenche os parâmetros com os valores dos IDs
        for ($i = 0; $i < count($arrayIdsSelecionados); $i++) {
            $params[] = $arrayIdsSelecionados[$i][0]; // Adiciona o id ao array de parâmetros
        }

        // Cria a string de placeholders para o SQL

        /*
        array_fill(0, count($params), '?') cria uma lista de placeholders (?),
        que são substituídos pelos valores dos parâmetros no momento da execução da consulta.
        Isso garante que os valores sejam escapados corretamente, evitando SQL Injection.
        */

        $placeholders = implode(',', array_fill(0, count($params), '?'));

        // Finaliza a consulta com os placeholders
        $sqlAprovarConteudo .= $placeholders . ")";

        // Prepara a consulta
        $stmtAprovarConteudo = $conexao->prepare($sqlAprovarConteudo);
        // Executa a consulta com os parâmetros
        //coloca os parâmetros no lugar dos placeholders
        $stmtAprovarConteudo->execute($params);
        $conexao->commit();

        // Redireciona para a página inicial após a autorização
        header("Location: TelaPrincipalAprovacao.php");
        exit();
    } catch (Exception $e) {
        $conexao->rollBack();
        header("Location: TelaPrincipalAprovacao.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos.";
}
?>