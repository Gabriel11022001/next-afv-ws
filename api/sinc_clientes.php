<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/get_parametros.php';
require_once __DIR__ . '/Utils/banco_dados.php';

try {
    $clientesPorPagina = 10;
    $paginaAtual = getParametro('pagina_atual');

    if (empty($paginaAtual)) {
        response(false, 'Informe página.', []);
    } else {
    
        if ($paginaAtual <= 0) {
            response(false, 'Página inválida!', []);
        } else {
            $offset = ($paginaAtual - 1) * $clientesPorPagina; 
            $bancoDados = getConexaoBanco();
            $queryConsultarClientes = 'SELECT * FROM tb_clientes LIMIT :clientes_por_pagina OFFSET :offset';
            $stmt = $bancoDados->prepare($queryConsultarClientes);
            $stmt->bindValue(':clientes_por_pagina', $clientesPorPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            response(true, 'Clientes obtidos com sucesso!', $clientes);
        }

    }

} catch (Exception $e) {
    // registrar o erro no arquivo de log

    response(false, 'Ocorreu um erro ao tentar-se sincronizar os clientes.', []);
}