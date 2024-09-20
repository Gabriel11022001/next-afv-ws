<?php

function descriptografar($nomeCampo, $dado) 
{
    
    if (base64_encode(base64_decode($dado, true)) === $dado) {

        var_dump(base64_decode($dado));
        exit;

        return base64_decode($dado);
    } else {
        throw new Exception('Erro ao tentar-se descriptografar o campo ' . $nomeCampo . ' na base64!');
    }

}