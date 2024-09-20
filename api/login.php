<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/banco_dados.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/get_parametros.php';

try {
    $email = getParametro('email');
    $senha = getParametro('senha');

    if (empty($email) || empty($senha)) {
        response(true, 'Informe o e-mail e senha para realizar login.');
    } else {
        $con = getConexaoBanco();
        $query = 'SELECT * FROM tb_usuarios WHERE email = :email AND senha = :senha';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($usuario)) {
            response(true, 'Login efetuado com sucesso.', [
                'id_usuario_logado' => $usuario['id'],
                'nome_usuario_logado' => $usuario['nome_completo'],
                'nivel_acesso_usuario_logado' => $usuario['nivel_acesso'],
                'ativo' => $usuario['ativo'],
                'ambiente' => ''
            ]);
        } else {
            response(true, 'E-mail ou senha inválidos.');
        }

    }

} catch (Exception $e) {
    // registrar erro no arquivo de log

    response(true, 'Ocorreu um erro, tente novamente!' . $e->getMessage());
}