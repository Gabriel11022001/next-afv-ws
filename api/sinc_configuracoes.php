<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/http_utils.php';

try {
    $caminhoArquivoConfiguracoes = __DIR__ . '/config/configuracao.json';
    $conteudo = file_get_contents($caminhoArquivoConfiguracoes, true);

    if (empty($conteudo)) {
        response(true, 'Ocorreu um erro ao tentar-se sincronizar as configurações.');
    } else {
        $conteudo = json_decode($conteudo);
        response(true, 'Sincronização de configurações realizada com sucesso.', $conteudo);
    }

} catch (Exception $e) {
    // registrar no arquivo de log o erro
    response(true, 'Ocorreu um erro ao tentar-se sincronizar as configurações.');
}