<?php

function response($sucesso = true, $mensagem = '', $corpo = null)
{

    if ($sucesso) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }

    echo json_encode([
        'ok' => $sucesso ? true : false,
        'mensagem' => $mensagem,
        'corpo' => $corpo
    ]);
}