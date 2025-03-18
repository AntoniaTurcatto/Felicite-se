<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Aprovar conteúdo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tabelas.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function excluir(codConteudoEspecificoETipoArray) {
            var confirmacao = confirm("Deseja realmente excluir este Conteudo?");

            if (confirmacao) {
                const codETipoArrayLocal = JSON.parse(codConteudoEspecificoETipoArray.value);
                const codConteudoEspecifico = codETipoArrayLocal[0];
                const tipo = codETipoArrayLocal[1];

                var form = document.createElement('form');
                form.method = 'post';
                var input = document.createElement('input');

                if(tipo === 'aplicativo'){
                    form.action = 'excluirAplicativo.php';
                    input.name = 'codAplicativo';

                } else if(tipo === 'artigo'){
                    form.action = 'excluirArtigo.php';
                    input.name = 'codArtigo';

                } else if(tipo === 'canalyoutube'){
                    form.action = 'excluirCanal.php';
                    input.name = 'codCanal';

                } else if(tipo === 'evento'){
                    form.action = 'excluirEvento.php';
                    input.name = 'codEvento';

                } else if(tipo === 'filme'){
                    form.action = 'excluirFilme.php';
                    input.name = 'codFilme';

                } else if(tipo === 'livro'){
                    form.action = 'excluirLivro.php';
                    input.name = 'codLivro';

                } else if(tipo === 'paginaweb'){
                    form.action = 'excluirSite.php';
                    input.name = 'codPagina';

                } else { // vai ser série (o unico que sobrou)
                    form.action = 'excluirSerie';
                    input.name = 'codSerie.php';
                }
                //var input = document.createElement('input');
                input.type = 'hidden';
                //input.name = 'codDoAtualizar';
                input.value = codConteudoEspecifico;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function visualizar(codConteudoEConteudoEspecificoETipoArray){
            const codConteudoEConteudoEspecificoETipoArrayLocal = JSON.parse(codConteudoEConteudoEspecificoETipoArray.value);
            const codConteudoEspecifico = codConteudoEConteudoEspecificoETipoArrayLocal[0];
            const tipo = codConteudoEConteudoEspecificoETipoArrayLocal[1];
            const codConteudo = codConteudoEConteudoEspecificoETipoArrayLocal[2];

            var form = document.createElement('form');
            form.method = 'post';
            var input = document.createElement('input');
            form.action = 'visualizarConteudo.php';
            input.name = 'visualizarConteudo';
            input.type = 'hidden';
            input.value = JSON.stringify(codConteudoEConteudoEspecificoETipoArrayLocal); // Converte o array para JSON;

            console.log(input.value);
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        let arrayIdsSelecionados = [];
        //$arrayIdsSelecionados[0][x] = IDs
        //$arrayIdsSelecionados[1][x] = TIPO
        let cont0Id = 0;
        //variavel para controlar o tamanho do array2D

        function autorizarConteudos(){
            var confirmacao = confirm("Deseja realmente AUTORIZAR esses Conteúdos?");

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
                
                console.log(arrayIdsSelecionados); // Para ver os IDs selecionados no console
                console.log(input.value);
                form.submit();
            }
           
        }

        
        function updateSelection(checkbox) {
            const arrayEId = JSON.parse(checkbox.value);
            if (checkbox.checked) {
                // Adiciona o id ao array se o checkbox estiver marcado
                arrayIdsSelecionados.push([arrayEId[0], arrayEId[1]]); //y - 0 (id) ; y = 1 (tipo)
                cont0Id++; 
            } else {
                let novoArray = [];
                for(let i = 0; i<cont0Id; i++){ // i = coluna/id
                    //id do elemento do checkbox (que deve ser retirado do array) !== id da repeticao atual 
                    if(arrayIdsSelecionados[i][0] !== arrayEId[0]){
                        //se for NÃO IDÊNTICO ele adiciona
                        //se for IDÊNTICO ele não adiciona
                        novoArray.push(arrayIdsSelecionados[i]); //adiciona id e tipo
                    }
                }
                arrayIdsSelecionados = novoArray;
                cont0Id = novoArray.length;
            }
            
            console.log(arrayIdsSelecionados); // Para ver os IDs selecionados no console
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
        <a href="MenuPrincipal.html">
            <button>
                <img src="imagem\icons8-abaixo-e-à-esquerda-100.png" alt="Ícone de retorno" class="icone-retorno">
            </button>
        </a>
    </div>
    
    <div id="titulo-para-aprovar">
        <h2> Conteúdos ainda não aprovados</h2>
    </div>
    
    <div class="table-container">
        <button type='button' class ='botaoAprovar' onclick='autorizarConteudos()'>Aprovar</button>
        <?php

            $arrayIdsSelecionados = array(); // Inicializa o array
            //$arrayIdsSelecionados[0][x] = IDs
            //$arrayIdsSelecionados[1][x] = TIPO

            echo "<table class='tabela-scroll'>
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição do conteudo</th>
                        <th>Descrição da indicação</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>";
                    include "funcoes.php";
                    $conexao = conectarPDO();

                    $sql = "SELECT c.*, app.codAplicativo, atg.codArtigo, ytb.codCanal,
                    evt.codEvento, filme.codFilme, lv.codLivro, web.codPagina, serie.codSerie
                    FROM conteudo c
                    LEFT JOIN aplicativo app ON app.codConteudo = c.codConteudo
                    LEFT JOIN artigo atg ON atg.codConteudo = c.codConteudo
                    LEFT JOIN canalyoutube ytb ON ytb.codConteudo = c.codConteudo
                    LEFT JOIN evento evt ON evt.codConteudo = c.codConteudo
                    LEFT JOIN filme ON filme.codConteudo = c.codConteudo
                    LEFT JOIN livro lv ON lv.codConteudo = c.codConteudo
                    LEFT JOIN paginaweb web ON web.codConteudo = c.codConteudo
                    LEFT JOIN serie ON serie.codConteudo = c.codConteudo
                    WHERE c.aprovado = 0";
                    $result = $conexao->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $id = $row["codConteudo"];

                            $tipo;
                            $codEspecifico;
                            $codConteudo = $row["codConteudo"];
                            //vendo de que tipo é o conteudo
                            if($row["codAplicativo"] != null){
                                $tipo = "aplicativo";
                                $codEspecifico = $row["codAplicativo"];

                            } else if($row["codArtigo"] != null){
                                $tipo = "artigo";
                                $codEspecifico = $row["codArtigo"];

                            } else if ($row["codCanal"]  != null){
                                $tipo = "canalyoutube";
                                $codEspecifico = $row["codCanal"];

                            } else if ($row["codEvento"]  != null){
                                $tipo = "evento";
                                $codEspecifico = $row["codEvento"];

                            } else if ($row["codFilme"]  != null){
                                $tipo = "filme";
                                $codEspecifico = $row["codFilme"];

                            } else if ($row["codLivro"]  != null){
                                $tipo = "livro";
                                $codEspecifico = $row["codLivro"];

                            } else if ($row["codPagina"]  != null){
                                $tipo = "paginaweb";
                                $codEspecifico = $row["codPagina"];

                            } else if ($row["codSerie"]  != null){
                                $tipo = "serie";
                                $codEspecifico = $row["codSerie"];

                            } else {
                                $tipo = "ERRO!";
                                $codEspecifico = -1;
                            }

                            echo "<td> <input type='checkbox' class='autorizar' name='autorizar' value='" . json_encode([$id, $tipo]) . "'  onclick='updateSelection(this)'/>
                            <td>" . $row["codConteudo"] . "</td>
                            <td>" . $row["nomeConteudo"] . "</td>
                            <td>" . $row["descricaoConteudo"] . "</td>
                            <td>" . $row["descricaoIndicacao"] . "</td>";
                            

                            echo "<td>" . $tipo . "</td>
                            <td>
                                <button class='excluir-botao' id='excluir' value='" . json_encode([$codEspecifico, $tipo]) . "' onclick='excluir(this)'></button>
                                <button class='visualizar-botao' id='visualizar' value='" . json_encode([$codEspecifico, $tipo, $codConteudo]) . "' onclick='visualizar(this)'></button>
                            </td>
                        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum dado encontrado</td></tr>";
                    }
                echo
                "</tbody>
            </table>";
        ?>
        
    </div>
</body>

</html>