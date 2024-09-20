<?php

function getParametro($nomeParametro) {
    $dadosCorpoRequisicao = file_get_contents('php://input');
    $dadosCorpoRequisicaoObj = json_decode($dadosCorpoRequisicao);
    $propriedadesObjetosRequisicao = get_object_vars($dadosCorpoRequisicaoObj);

    if (!key_exists($nomeParametro, $propriedadesObjetosRequisicao)) {
        throw new Exception('No objeto json não existe uma propriedade definida com o nome: ' . $nomeParametro);
    }

    return $propriedadesObjetosRequisicao[$nomeParametro];
}