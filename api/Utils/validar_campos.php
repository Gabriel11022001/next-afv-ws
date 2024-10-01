<?php

function validarFormularioCliente($tipoCliente, $dadosCliente) {
    $erro = '';

    if ($tipoCliente == 'pf') {
        // validar campos da pessoa fisica
        $erro = validarCamposPessoaFisica($dadosCliente);
    } else {    
        // validar campos da pessoa juridica
        $erro = validarCamposPessoaJuridica($dadosCliente);
    }  

    return $erro;
}

function validarCamposPessoaFisica($dadosPessoaFisica) {
    $erro = '';

    return $erro;
}

function validarCamposPessoaJuridica($dadosPessoaJuridica) {
    $erro = '';

    return $erro;
}