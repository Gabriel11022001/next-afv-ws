<?php

function getConfiguracoesBanco()
{
    $configuracoes = [];
    $caminhoArquivo = __DIR__ . '/../config/configuracao.json';
    $jsonArquivoConfig = file_get_contents($caminhoArquivo);

    if ($jsonArquivoConfig === false) {
        die('Erro ao tentar-se ler o conteúdo do arquivo configuracao.json');
    } else {
        $configuracoesLidas = json_decode($jsonArquivoConfig, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Erro ao decodificar o JSON configuracao.json: ' . json_last_error_msg());
        } else {
            $configuracoes['usuario'] = $configuracoesLidas['banco_dados']['usuario'];
            $configuracoes['senha'] = $configuracoesLidas['banco_dados']['senha'];
            $configuracoes['nome_banco'] = $configuracoesLidas['banco_dados']['nome_banco'];
            $configuracoes['host'] = $configuracoesLidas['banco_dados']['host'];
        }

    }

    return $configuracoes;
}

function getConexaoBanco()
{
    
    try {
        $configuracoesBancoDados = getConfiguracoesBanco();
        $usuario = $configuracoesBancoDados['usuario'];
        $senha = $configuracoesBancoDados['senha'];
        $nomeBancoDados = $configuracoesBancoDados['nome_banco'];
        $host = $configuracoesBancoDados['host'];

        $pdo = new PDO('pgsql:host=' . $host . ';dbname=' . $nomeBancoDados . ';port=5432', $usuario, $senha);

        return $pdo;
    } catch (Exception $e) {
        throw $e;
    }

}
