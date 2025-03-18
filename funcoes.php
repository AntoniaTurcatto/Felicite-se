<?php
// função de conexão
function conectarPDO(): object
{
    $localServidor = "localhost";
    $nomeBaseDados = "projetos";
    $senha = "2275";
    $usuario = "root";

    try {
        $conexao = new PDO("mysql:host=$localServidor;dbname=$nomeBaseDados", $usuario, $senha);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ativar mensagens de erro
    } catch (PDOException $e) {
        echo "Falha na conexão: " . $e->getMessage();
    }
    return $conexao;
}

// função para inserir usuário
function inserirUsuario(object $conexao, $nome, $genero, $tipo, $email, $senha,$matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor): void
{
    $comandoSQL = "INSERT INTO usuario (nomeUsuario, generoUsuario, tipoUsuario, emailUsuario, senhaUsuario, matriculaEstudante, matriculaServidor, cargoServidor, siapeServidor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$nome, $genero, $tipo, $email, $senha,$matriculaEstudante, $matriculaServidor, $cargoServidor, $siapeServidor]);

        if ($dados) {
            if ($tipo === 0) {
                echo "Aluno cadastrado com sucesso";
            } else if($tipo === 1){
                echo "Servidor cadastrado com sucesso";
            } else {
                echo "Administrador cadastrado com sucesso";
            }
        } else {
            echo "Não foi possível cadastrar o usuário";
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir o usuário: " . $e->getMessage();
    }
}

// função para inserir livros
function inserirLivros(object $conexao, $editora, $capaLivro, $nomeAutor, $anoLancamento, $quantidadePag, $generoLivro, $codConteudo)
{
    $comandoSQL = "INSERT INTO livro (editoraLivro, capaLivro, anoLivro, paginasLivro, autorLivro, generoLivro, codConteudo) VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$editora, $capaLivro, $anoLancamento, $quantidadePag, $nomeAutor, $generoLivro, $codConteudo]);
        if ($dados) {
            echo "Livro cadastrado com sucesso";
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir o livro: " . $e->getMessage();
    }
}

// função para cadastro de séries
function inserirSeries(object $conexao, $capaSerie, $sinopseSerie, $tempSeries, $anoLancamentoSerie, $plataforma, $codConteudoSerie)
{
    $comandoSQL = "INSERT INTO serie (capaSerie, sinopseSerie, temporadaSerie, anoLancamentoSerie, plataformaSerie, codConteudo) VALUES (?, ?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$capaSerie, $sinopseSerie, $tempSeries, $anoLancamentoSerie, $plataforma, $codConteudoSerie]);
        if ($dados) {
            echo "Série Cadastrada com sucesso!";
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir a série: " . $e->getMessage();
    }
}

function inserirSites(object $conexao, $linkPagina, $autorPagina, $codConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo)
{

    /*
    INSERT INTO paginaweb (codPagina, linkPagina, autorPagina,
                            descricaoConteudo, descricaoIndicacao, tematicaConteudo,
                            codConteudo)
                            VALUES (NULL, ?, ?, ?, ?, ?, ?)
    */
    $comandoSQL = "INSERT INTO paginaweb (linkPagina, autorPagina, codConteudo, 
    descricaoConteudo, descricaoIndicacao, tematicaConteudo) VALUES (?, ?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$linkPagina, $autorPagina, $codConteudo, $descricaoConteudo, $descricaoIndicacao, $tematicaConteudo]);
        echo "Site Cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o Site: " . $e->getMessage();
    }
}

function inserirCanalYoutube(object $conexao, $linkCanal, $capaCanal, $codConteudo)
{
    $comandoSQL = "INSERT INTO canalyoutube (linkCanal, capaCanal, codConteudo) VALUES (?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$linkCanal, $capaCanal, $codConteudo]);
        echo "Canal do Youtube Cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o Canal do Youtube: " . $e->getMessage();
    }
}


function inserirEventos(object $conexao, $dataEvento, $localEvento, $responsavelEvento, $codConteudo)
{
    $comandoSQL = "INSERT INTO evento (dataEvento, localEvento,responsavelEvento ,codConteudo) VALUES (?, ?, ?,?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$dataEvento, $localEvento, $responsavelEvento, $codConteudo]);
        echo "Evento Cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o Evento: " . $e->getMessage();
    }
}

function inserirArtigo(object $conexao, $linkArtigo, $resumoArtigo, $anoPublicacao, $autorArtigo, $codConteudo)
{
    $comandoSQL = "INSERT INTO artigo (linkArtigo, resumoArtigo,anoPublicacao,autorArtigo ,codConteudo) VALUES (?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$linkArtigo, $resumoArtigo, $anoPublicacao, $autorArtigo, $codConteudo]);
        echo "Artigo Cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o Artigo: " . $e->getMessage();
    }
}

function inserirAplicativo(object $conexao, $logoAplicativo, $linkAplicativo, $desenvolvedoresAplicativo, $gratisAplicativo, $codConteudo)
{
    $comandoSQL = "INSERT INTO aplicativo (logoAplicativo, linkAplicativo, desenvolvedoresAplicativo, gratisAplicativo, codConteudo) VALUES (?, ?, ?, ?, ?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$logoAplicativo, $linkAplicativo, $desenvolvedoresAplicativo, $gratisAplicativo, $codConteudo]);
        echo "Aplicativo Cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o Aplicativo: " . $e->getMessage();
    }
}

function inserirFilme(object $conexao, $capaFilme, $sinopseFilme, $duracaoFilme, $anoLancamentoFilme, $plataformaFilme, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao, $ultimoIDConteudo)
{
    try {
        $conexao->beginTransaction();



        $comandoSQL = "INSERT INTO filme (codConteudo, capaFilme, sinopseFilme, duracaoFilme, anoLancamentoFilme, plataformaFilme) VALUES (?, ?, ?, ?, ?, ?)";
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$ultimoIDConteudo, $capaFilme, $sinopseFilme, $duracaoFilme, $anoLancamentoFilme, $plataformaFilme]);

        $conexao->commit();
        return "Filme Cadastrado com sucesso!";
    } catch (PDOException $e) {
        $conexao->rollBack();
        return "Erro ao cadastrar filme: " . $e->getMessage();
    }
}


function inserirEmocoes(object $conexao, $tipoEmocao, $dataEmocao)
{
    $comandoSQL = "INSERT INTO emocao (tipoEmocao, dataEmocao) VALUES (?,?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$tipoEmocao, $dataEmocao]);
        echo "Emoção Cadastrada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir a Emoção: " . $e->getMessage();
    }
}

function inserirTematica(object $conexao, $nomeTematica, $descricaoTematica, $imagemTematica)
{
    $comandoSQL = "INSERT INTO tematica (nomeTematica, descricaoTematica, imagemTematica) VALUES (?,?,?)";

    try {
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$nomeTematica, $descricaoTematica, $imagemTematica]);
        echo "Temática Cadastrada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir a Temática: " . $e->getMessage();
    }
}

function inserirConteudo($conexao, $nomeConteudo, $descricaoConteudo, $descricaoIndicacao)
{
    try {
        $comandoSQL = "INSERT INTO conteudo (nomeConteudo, descricaoConteudo, descricaoIndicacao, aprovado) VALUES (?, ?, ?, 1)";
        $dados = $conexao->prepare($comandoSQL);
        $dados->execute([$nomeConteudo, $descricaoConteudo, $descricaoIndicacao]);

        // Retorna o último ID inserido
        return $conexao->lastInsertId();
    } catch (PDOException $e) {
        // Trate qualquer exceção que possa ocorrer durante a inserção
        echo "Erro ao cadastrar conteúdo: " . $e->getMessage();
        return false;
    }
}

function cadastrarConteudoTematica($conexao, $codConteudo, $codTematica)
{
    $query = "INSERT INTO conteudoTematica (codConteudo, codTematica) VALUES (:codConteudo, :codTematica)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':codConteudo', $codConteudo, PDO::PARAM_INT);
    $stmt->bindParam(':codTematica', $codTematica, PDO::PARAM_INT);
    $stmt->execute();
}

function getSenhaDeAdmin($conexao, $email){
    $query = "select senhaUsuario from usuario where emailUsuario = :email AND tipoUsuario = :tipo";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':tipo', 2, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}