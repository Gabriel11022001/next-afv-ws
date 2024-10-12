<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/get_parametros.php';
require_once __DIR__ . '/Utils/banco_dados.php';

try {
    $categoriasPorPagina = 10;
    $paginaAtual = getParametro('pagina_atual');

    if (empty($paginaAtual)) {
        response(false, 'Informe a página atual.', []);
        exit;
    }

    if ($paginaAtual < 1) {
        response(false, 'Página inválida.', []);
        exit;
    }

    $offset = ($paginaAtual - 1) * $categoriasPorPagina;
    $bancoDados = getConexaoBanco(); 
    $stmt = $bancoDados->prepare('SELECT * FROM tb_categorias_produtos WHERE status = true LIMIT :limite OFFSET :offset');
    $stmt->bindValue(':limite', $categoriasPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    response(true, 'Categorias obtidas com sucesso.', $categorias);
} catch (Exception $e) {
    // registrar o erro no arquivo de log

    response(false, 'Ocorreu um erro ao tentar-se sincronizar as categorias de produtos.', []);
}