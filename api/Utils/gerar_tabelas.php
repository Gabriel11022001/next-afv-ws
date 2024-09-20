<?php

require_once __DIR__ . '/banco_dados.php';

// arquivo que ao ser executado gera todas as tabelas do banco de dados

try {
    $bancoDados = getConexaoBanco();
    // criar tabelas no banco de dados
    $arquivo_sql_gerar_tabelas = __DIR__ . '/../scripts/criar_tabelas.sql';
    $conteudo = file_get_contents($arquivo_sql_gerar_tabelas);
    $queries = explode(';', $conteudo);
    
    foreach ($queries as $query) {
        $query = trim($query);

        if (!empty($query))  {
            $bancoDados->exec($query);
        }

    }

    echo 'Concluiu a criação das tabelas na base de dados.' . PHP_EOL;
} catch (Exception $e) {
    echo 'Ocorreu um erro: ' . $e->getMessage() . PHP_EOL;
}
