<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/get_parametros.php';
require_once __DIR__ . '/Utils/banco_dados.php';

try {
    $produtosPorPagina = 10;
    $paginaAtual = getParametro('pagina_atual');

    if (empty($paginaAtual)) {
        response(false, 'Informe a página atual.', []);
        exit;
    }

    if ($paginaAtual < 1) {
        response(false, 'Página inválida.', []);
        exit;
    }

    $offset = ($paginaAtual - 1) * $produtosPorPagina;
    $bancoDados = getConexaoBanco(); 
    $queryConsultarProdutos = 'SELECT * FROM tb_produtos WHERE status = true ORDER BY nome_produto ASC LIMIT :limite OFFSET :offset';
    $stmt = $bancoDados->prepare($queryConsultarProdutos);
    $stmt->bindValue(':limite', $produtosPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    response(true, 'Produtos obtidos com sucesso.', $stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    // registrar erro no arquivo de log

    response(false, 'Ocorreu um erro ao tentar-se sincronizar os produtos.', []);
}