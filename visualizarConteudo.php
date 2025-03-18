<?php
    include "funcoes.php";
    $codConteudoEspecificoETipo;
    $codConteudoEspecifico;
    $tipoConteudo;
    $codConteudo;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['visualizarConteudo'])) {
        $codConteudoEspecificoETipo = json_decode($_POST['visualizarConteudo'], true);
        $codConteudoEspecifico = $codConteudoEspecificoETipo[0];
        $tipoConteudo = $codConteudoEspecificoETipo[1];
        $codConteudo = $codConteudoEspecificoETipo[2];
        
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Livros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>

        function aprovar(codConteudo, tipo){
            var confirmacao = confirm("Deseja realmente AUTORIZAR esses Conteúdos?");
            const arrayIdsSelecionados = [];
            arrayIdsSelecionados.push([codConteudo, tipo]);
            if (confirmacao) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'autorizarConteudo.php';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'arrayIdsSelecionados';
                input.value = JSON.stringify(arrayIdsSelecionados); // Converte o array para JSON
                form.appendChild(input);
                document.body.appendChild(form);
                console.log(input.value);
                form.submit();
            }
        }

    </script>

</head>

<body>
    <div class="header-gim">
        <div>
            <div class="ifsul2">IFSul Campus Venâncio Aires</div>
        </div>
    </div>
    <div class="retornar-botao">
        <a href="TelaPrincipalAprovacao.php">
            <button>
                <img src="imagem\icons8-abaixo-e-à-esquerda-100.png" alt="Ícone de retorno" class="icone-retorno">
            </button>
        </a>
    </div>
    <div id="titulo-para-aprovar">
        <h2> Conteúdos ainda não aprovados</h2>
    </div>
    <div class="table-container">
        <table class="tabela-scroll">
            <thead>
            <?php
                /* CONTEUDO
                    codConteudo,nomeConteudo,descricaoConteudo,descricaoIndicacao,aprovado (não precisa)
                */
                echo "<tr>
                    <th></th>
                    <th>Nome</th>
                    <th>descricaoConteudo</th>
                    <th>descricaoIndicacao</th>";


                if($tipoConteudo == "aplicativo"){
                    //CAMPOS 
                    /*
                        `codAplicativo` int(11) NOT NULL,
                        `logoAplicativo` blob DEFAULT NULL,
                        `linkAplicativo` varchar(80) NOT NULL,
                        `desenvolvedoresAplicativo` varchar(60) DEFAULT NULL,
                        `gratisAplicativo` int(11) DEFAULT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>logoAplicativo</th>
                    <th>linkAplicativo</th>
                    <th>desenvolvedoresAplicativo</th>
                    <th>gratisAplicativo</th>
                    ";

                } else if($tipoConteudo == "artigo"){
                    //CAMPOS 
                    /*
                        `codArtigo` int(11) NOT NULL,
                        `linkArtigo` varchar(80) NOT NULL,
                        `resumoArtigo` varchar(250) NOT NULL,
                        `anoPublicacao` int(11) NOT NULL,
                        `autorArtigo` varchar(80) DEFAULT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>linkArtigo</th>
                    <th>resumoArtigo</th>
                    <th>anoPublicacao</th>
                    <th>autorArtigo</th>
                    ";

                } else if ($tipoConteudo == "canalyoutube"){
                    //CAMPOS 
                    /*
                        `codCanal` int(11) NOT NULL,
                        `linkCanal` varchar(80) NOT NULL,
                        `capaCanal` blob NOT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>linkCanal</th>
                    <th>capaCanal</th>
                    ";

                } else if ($tipoConteudo == "evento"){
                    //CAMPOS 
                    /*
                        `codEvento` int(11) NOT NULL,
                        `dataEvento` date NOT NULL,
                        `localEvento` varchar(80) NOT NULL,
                        `responsavelEvento` varchar(40) NOT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>dataEvento</th>
                    <th>localEvento</th>
                    <th>responsavelEvento</th>
                    ";

                } else if ($tipoConteudo == "filme"){
                    //CAMPOS 
                    /*
                        `codFilme` int(11) NOT NULL,
                        `capaFilme` blob DEFAULT NULL,
                        `sinopseFilme` varchar(100) NOT NULL,
                        `duracaoFilme` int(11) NOT NULL,
                        `anoLancamentoFilme` year(4) NOT NULL,
                        `plataformaFilme` varchar(40) DEFAULT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>capaFilme</th>
                    <th>sinopseFilme</th>
                    <th>duracaoFilme</th>
                    <th>anoLancamentoFilme</th>
                    <th>plataformaFilme</th>
                    ";

                } else if ($tipoConteudo == "livro"){
                    //CAMPOS 
                    /*
                        `codLivro` int(11) NOT NULL,
                        `editoraLivro` varchar(20) NOT NULL,
                        `capaLivro` longblob NOT NULL,
                        `anoLivro` year(4) NOT NULL,
                        `paginasLivro` varchar(4) NOT NULL,
                        `autorLivro` varchar(40) NOT NULL,
                        `generoLivro` varchar(20) NOT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>editoraLivro</th>
                    <th>capaLivro</th>
                    <th>anoLivro</th>
                    <th>paginasLivro</th>
                    <th>autorLivro</th>
                    <th>generoLivro</th>
                    ";

                } else if ($tipoConteudo == "paginaweb"){
                    //CAMPOS 
                    /*
                        `codPagina` int(11) NOT NULL,
                        `linkPagina` varchar(80) NOT NULL,
                        `autorPagina` varchar(40) DEFAULT NULL,
                        `descricaoConteudo` varchar(90) NOT NULL,
                        `descricaoIndicacao` varchar(90) NOT NULL,
                        `tematicaConteudo` int(11) NOT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>linkPagina</th>
                    <th>autorPagina</th>
                    <th>tematicaConteudo</th>
                    ";

                } else if ($tipoConteudo == "serie"){
                    //CAMPOS 
                    /*
                        `codSerie` int(11) NOT NULL,
                        `capaSerie` longblob DEFAULT NULL,
                        `sinopseSerie` varchar(100) NOT NULL,
                        `temporadaSerie` int(11) NOT NULL,
                        `anoLancamentoSerie` year(4) NOT NULL,
                        `plataformaSerie` varchar(40) DEFAULT NULL,
                        `codConteudo` int(11) NOT NULL
                    */
                    echo "<th>capaSerie</th>
                    <th>sinopseSerie</th>
                    <th>temporadaSerie</th>
                    <th>anoLancamentoSerie</th>
                    <th>plataformaSerie</th>
                    ";
                    
                } else {
                    //CAMPOS ERRO
                    echo "<td> ERRO </td>";
                }

                echo "<th>Ações</th> <!-- Nova coluna para botões de ação -->
                </tr>
            </thead>
            <tbody>
            <tr><td>" . $codConteudo . "</td>";
                
                $conexao = conectarPDO();

                //$sql = "SELECT * from conteudo INNER JOIN " . $tipoConteudo . " conteudoEspecifico on conteudoEspecifico.codConteudo = conteudo.codConteudo where conteudo.codConteudo=" . $codConteudo;
                //$result = $conexao->query($sql);

                $sql = "SELECT * FROM conteudo INNER JOIN " . $tipoConteudo . " conteudoEspecifico ON conteudoEspecifico.codConteudo = conteudo.codConteudo WHERE conteudo.codConteudo = :codConteudo";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
                $stmt->execute();
                 // Obtém todos os resultados da consulta em um array associativo

                //estrutura do row: colunasDeConteudo, colunasConteudoEspecifico

                // Preencher a tabela com os dados do banco de dados
                if ($stmt->rowCount() > 0) {

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Codificar a imagem em base64
                        $imagemBase64;
                        //$imagemBase64 = base64_encode($row["capaLivro"]);

                        /*HEADER DA TABELA
                        echo "<tr>
                            <th></th>
                            <th>Nome</th>
                            <th>descricaoConteudo</th>
                            <th>descricaoIndicacao</th>";
                        */

                        /* CONTEUDO
                            codConteudo,nomeConteudo,descricaoConteudo,descricaoIndicacao,aprovado (não precisa)
                        */
                        echo "<td>" . $row["nomeConteudo"] . "</td>
                        <td>" . $row["descricaoConteudo"] . "</td>
                        <td>" . $row["descricaoIndicacao"] . "</td>
                        ";

                        if(isset($row["codAplicativo"])){
                            //CAMPOS 
                            /*
                                `codAplicativo` int(11) NOT NULL,
                                `logoAplicativo` blob DEFAULT NULL,
                                `linkAplicativo` varchar(80) NOT NULL,
                                `desenvolvedoresAplicativo` varchar(60) DEFAULT NULL,
                                `gratisAplicativo` int(11) DEFAULT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>logoAplicativo</th>
                                    <th>linkAplicativo</th>
                                    <th>desenvolvedoresAplicativo</th>
                                    <th>gratisAplicativo</th>";
                            */
                            $imagemBase64 = base64_encode($row["logoAplicativo"]);
                            echo "
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do App' style='width:65px;height:75px;'></td>
                                <td><a href='" . $row["linkAplicativo"] . "'>Link</a></td>
                                <td>" . $row["desenvolvedoresAplicativo"] . "</td>
                                <td>" . $row["gratisAplicativo"] . "</td>
                                ";

                        } else if(isset($row["codArtigo"])){
                            //CAMPOS 
                            /*
                                `codArtigo` int(11) NOT NULL,
                                `linkArtigo` varchar(80) NOT NULL,
                                `resumoArtigo` varchar(250) NOT NULL,
                                `anoPublicacao` int(11) NOT NULL,
                                `autorArtigo` varchar(80) DEFAULT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>linkArtigo</th>
                                    <th>resumoArtigo</th>
                                    <th>anoPublicacao</th>
                                    <th>autorArtigo</th>
                                    ";
                            */
                            echo "
                                <td><a href='" . $row["linkArtigo"] . "'>Link</a></td>
                                <td>" . $row["resumoArtigo"] . "</td>
                                <td>" . $row["anoPublicacao"] . "</td>
                                <td>" . $row["autorArtigo"] . "</td>
                                ";

                        } else if (isset($row["codCanal"])){
                            //CAMPOS 
                            /*
                                `codCanal` int(11) NOT NULL,
                                `linkCanal` varchar(80) NOT NULL,
                                `capaCanal` blob NOT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>linkCanal</th>
                                    <th>capaCanal</th>
                                    ";
                            */
                            $imagemBase64 = base64_encode($row["capaCanal"]);
                            echo "
                                <td><a href='" . $row["linkCanal"] . "'>Link</a></td>
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do Canal' style='width:65px;height:75px;'></td>
                                ";

                        } else if (isset($row["codEvento"])){
                            //CAMPOS 
                            /*
                                `codEvento` int(11) NOT NULL,
                                `dataEvento` date NOT NULL,
                                `localEvento` varchar(80) NOT NULL,
                                `responsavelEvento` varchar(40) NOT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>dataEvento</th>
                                    <th>localEvento</th>
                                    <th>responsavelEvento</th>
                                    ";
                            */
                            echo "
                                <td>" . $row["dataEvento"] . "</td>
                                <td>" . $row["localEvento"] . "</td>
                                <td>" . $row["responsavelEvento"] . "</td>
                                ";

                        } else if (isset($row["codFilme"])){
                            //CAMPOS 
                            /*
                                `codFilme` int(11) NOT NULL,
                                `capaFilme` blob DEFAULT NULL,
                                `sinopseFilme` varchar(100) NOT NULL,
                                `duracaoFilme` int(11) NOT NULL,
                                `anoLancamentoFilme` year(4) NOT NULL,
                                `plataformaFilme` varchar(40) DEFAULT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>capaFilme</th>
                                    <th>sinopseFilme</th>
                                    <th>duracaoFilme</th>
                                    <th>anoLancamentoFilme</th>
                                    <th>plataformaFilme</th>
                                    ";
                            */
                            $imagemBase64 = base64_encode($row["capaFilme"]);
                            echo "
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do Filme' style='width:65px;height:75px;'></td>
                                <td>" . $row["sinopseFilme"] . "</td>
                                <td>" . $row["duracaoFilme"] . "</td>
                                <td>" . $row["anoLancamentoFilme"] . "</td>
                                <td>" . $row["plataformaFilme"] . "</td>
                                ";

                        } else if (isset($row["codLivro"])){
                            //CAMPOS 
                            /*
                                `codLivro` int(11) NOT NULL,
                                `editoraLivro` varchar(20) NOT NULL,
                                `capaLivro` longblob NOT NULL,
                                `anoLivro` year(4) NOT NULL,
                                `paginasLivro` varchar(4) NOT NULL,
                                `autorLivro` varchar(40) NOT NULL,
                                `generoLivro` varchar(20) NOT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>editoraLivro</th>
                                    <th>capaLivro</th>
                                    <th>anoLivro</th>
                                    <th>paginasLivro</th>
                                    <th>autorLivro</th>
                                    <th>generoLivro</th>
                                    ";
                            */
                            $imagemBase64 = base64_encode($row["capaLivro"]);
                            echo "
                                <td>" . $row["editoraLivro"] . "</td>
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa do Livro' style='width:65px;height:75px;'></td>
                                <td>" . $row["anoLivro"] . "</td>
                                <td>" . $row["paginasLivro"] . "</td>
                                <td>" . $row["autorLivro"] . "</td>
                                <td>" . $row["generoLivro"] . "</td>";
                            
                        } else if (isset($row["codPagina"])){
                            //CAMPOS 
                            /*
                                `codPagina` int(11) NOT NULL,
                                `linkPagina` varchar(80) NOT NULL,
                                `autorPagina` varchar(40) DEFAULT NULL,
                                `descricaoConteudo` varchar(90) NOT NULL,
                                `descricaoIndicacao` varchar(90) NOT NULL,
                                `tematicaConteudo` int(11) NOT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>linkPagina</th>
                                    <th>autorPagina</th>
                                    <th>tematicaConteudo</th>
                                    ";
                            */
                            echo "
                                <td><a href='" . $row["linkPagina"] . "'>Link</a></td>
                                <td>" . $row["autorPagina"] . "</td>
                                <td>" . $row["tematicaConteudo"] . "</td>
                                ";

                        } else if (isset($row["codSerie"])){
                            //CAMPOS 
                            /*
                                `codSerie` int(11) NOT NULL,
                                `capaSerie` longblob DEFAULT NULL,
                                `sinopseSerie` varchar(100) NOT NULL,
                                `temporadaSerie` int(11) NOT NULL,
                                `anoLancamentoSerie` year(4) NOT NULL,
                                `plataformaSerie` varchar(40) DEFAULT NULL,
                                `codConteudo` int(11) NOT NULL

                                echo "<th>capaSerie</th>
                                    <th>sinopseSerie</th>
                                    <th>temporadaSerie</th>
                                    <th>anoLancamentoSerie</th>
                                    <th>plataformaSerie</th>
                                    ";
                            */
                            $imagemBase64 = base64_encode($row["capaSerie"]);
                            echo "
                                <td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='Capa da Serie' style='width:65px;height:75px;'></td>
                                <td>" . $row["sinopseSerie"] . "</td>
                                <td>" . $row["temporadaSerie"] . "</td>
                                <td>" . $row["anoLancamentoSerie"] . "</td>
                                <td>" . $row["plataformaSerie"] . "</td>
                                ";
                            
                        } else {
                            //CAMPOS ERRO
                            echo "<td> ERRO </td>";
                        }

                        
                            echo "<td>
                                <button class='aprovar-botao' id='aprovar' value='" . $codConteudo . ", " . $tipoConteudo . "' onclick='aprovar(\"" . $codConteudo . "\", \"" . $tipoConteudo . "\")'></button>
                            </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum dado encontrado</td></tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</body>

</html>