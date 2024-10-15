<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/banco_dados.php';

try {
    $totais = [
        'total_clientes' => 0,
        'total_categorias' => 0,
        'total_produtos' => 0,
        'total_vendas' => 0
    ];

    // obter total de clientes cadastrados
    $bancoDados = getConexaoBanco();
    $stmt = $bancoDados->prepare('SELECT COUNT(id) AS total_clientes FROM tb_clientes');
    $stmt->execute();
    $totais['total_clientes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_clientes'];

    // obter total de categorias de produtos cadastrados
    $stmt = $bancoDados->prepare('SELECT COUNT(id) AS total_categorias FROM tb_categorias_produtos');
    $stmt->execute();
    $totais['total_categorias'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_categorias'];

    $stmt = $bancoDados->prepare('SELECT COUNT(id) AS total_produtos FROM tb_produtos');
    $stmt->execute();
    $totais['total_produtos'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_produtos'];

    response(true, 'Totais obtidos com sucesso.', [
        'total_clientes' => $totais['total_clientes'],
        'total_categorias' => $totais['total_categorias'],
        'total_produtos' => $totais['total_produtos'],
        'total_vendas' => $totais['total_vendas']
    ]);
} catch (Exception $e) {
    // registrar erro no arquivo de log

    response(false, 'Ocorreu um erro ao tentar-se obter os totais.');
}