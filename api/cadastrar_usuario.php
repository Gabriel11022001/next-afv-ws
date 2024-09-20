<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/banco_dados.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/get_parametros.php';

try {
    $nomeCompleto = trim(getParametro('nome_completo'));
    $email = trim(getParametro('email'));
    $senha = trim(getParametro('senha'));
    $nivelAcesso = trim(getParametro('nivel_acesso'));

    if (empty($nomeCompleto) || empty($email) || empty($senha) || empty($nivelAcesso)) {
        response(true, 'Informe todos os dados obrigatórios.');
    } else {
        // validar o tamanho da senha
        
        if (strlen($senha) < 6) {
            response(true, 'A senha deve possuir no mínimo 6 caracteres.');
        } else {
            // criptografar a senha
            $senha = md5($senha);

            // validar se já existe um usuário cadastrado com o e-mail informado
            $queryValidarUsuarioEmailInformado = 'SELECT * FROM tb_usuarios WHERE email = :email';
        }

    }

} catch (Exception $e) {

}