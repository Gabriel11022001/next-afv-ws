<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/get_parametros.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/banco_dados.php';

try {
    $emailUsuario = trim(getParametro('email'));
    $senhaAnterior = trim(getParametro('senha_anterior'));
    $novaSenha = trim(getParametro('nova_senha'));

    if (empty($emailUsuario) || empty($senhaAnterior) || empty($novaSenha)) {
        response(true, 'Informe todos os dados obrigatórios para a alteração de senha.');
        exit;
    } 

    if (strlen($novaSenha) < 5) {
        response(true, 'A senha deve conter no mínimo cinco caracteres.');
    }

    if ($senhaAnterior === $novaSenha) {
        response(true, 'A senha atual é igual a nova senha.');
        exit;
    }
    
    $bancoDados = getConexaoBanco();

    $stmt = $bancoDados->prepare('SELECT * FROM tb_usuarios WHERE email = :email AND senha = :senha_atual');
    $stmt->bindValue(':email', $emailUsuario);
    $stmt->bindValue(':senha_atual', md5($senhaAnterior));
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($usuario)) {
        response(true, 'Senha atual incorreta.');
        exit;
    }

    $novaSenha = md5($novaSenha);
    $stmt = $bancoDados->prepare('UPDATE tb_usuarios SET senha = :nova_senha WHERE email = :email_usuario');
    $stmt->bindValue(':email_usuario', $emailUsuario);
    $stmt->bindValue(':nova_senha', $novaSenha);
    
    if ($stmt->execute()) {
        response(true, 'Senha alterada com sucesso.');
    } else {
        response(false, 'Ocorreu um erro ao tentar-se alterar a senha.');
    }

} catch (Exception $e) {
    // registrar erro no arquivo de log

    response(false, 'Ocorreu um erro ao tentar-se alterar a senha.');
}