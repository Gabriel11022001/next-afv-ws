<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/Utils/get_parametros.php';
require_once __DIR__ . '/Utils/http_utils.php';
require_once __DIR__ . '/Utils/banco_dados.php';
require_once __DIR__ . '/Utils/validar_campos.php';

$bancoDados = getConexaoBanco();
$bancoDados->beginTransaction();

try {
    $tipoCliente = trim(getParametro('tipo_pessoa'));
    $telefoneCelular = trim(getParametro('telefone_celular'));
    $telefoneFixo = trim(getParametro('telefone_fixo'));
    $telefoneComplementar = trim(getParametro('telefone_complementar'));
    $email = trim(getParametro('email'));
    // dados do endereço
    $cep = trim(getParametro('cep'));
    $complemento = trim(getParametro('complemento'));
    $bairro = trim(getParametro('bairro'));
    $endereco = trim(getParametro('endereco'));
    $cidade = trim(getParametro('cidade'));
    $numero = trim(getParametro('numero'));
    $uf = trim(getParametro('estado'));

    if ($tipoCliente == 'pf') {
        // cadastrar cliente pf
        $nomeCompleto = trim(getParametro('nome_completo'));
        $cpf = trim(getParametro('cpf'));
        $dataNascimento = trim(getParametro('data_nascimento'));
        $genero = trim(getParametro('sexo'));

        $msgErroValidarCampos = validarFormularioCliente('pf', [
            'nome_completo' => $nomeCompleto,
            'cpf' => $cpf,
            'data_nascimento' => $dataNascimento,
            'genero' => $genero,
            'email' => $email,
            'telefone_celular' => $telefoneCelular,
            'telefone_complementar' => $telefoneComplementar,
            'telefone_fixo' => $telefoneFixo,
            'cep' => $cep,
            'endereco' => $endereco,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'numero' => $numero,
            'uf' => $uf
        ]);

        if (!empty($msgErroValidarCampos)) {
            response(true, $msgErroValidarCampos);
        } else {
            // validar se já existe um cliente cadastrado com o cpf informado na base de dados
            $stmt = $bancoDados->prepare('SELECT id FROM tb_clientes WHERE cpf = :cpf');
            $stmt->bindValue(':cpf', $cpf);
            $stmt->execute();

            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                response(true, 'Já existe um cliente cadastrado com esse cpf, informe outro cpf.');
            } else {
                
            }

        }

    } else {
        // cadastrar cliente pj
    }

} catch (Exception $e) {
    $bancoDados->rollBack();
    // escrever erro no arquivo de log
}
