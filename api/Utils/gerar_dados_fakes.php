<?php

require_once 'banco_dados.php';

function gerarClientesFake(PDO $bancoDados) {

    // gerar 1000 clientes fakes para testes
    for ($contadorClientes = 0; $contadorClientes < 1000; $contadorClientes++) {
        $query = 'INSERT INTO tb_clientes(tipo_pessoa, email, telefone_celular, telefone_complementar, telefone_fixo, nome_completo,
        razao_social, cpf, cnpj, data_nascimento, sexo, inscricao_estadual, link_site)
        VALUES(
            :tipo_pessoa,
            :email,
            :telefone_celular,
            :telefone_complementar,
            :telefone_fixo,
            :nome_completo,
            :razao_social,
            :cpf,
            :cnpj,
            :data_nascimento,
            :sexo,
            :inscricao_estadual,
            :link_site
        )';

        $stmt = $bancoDados->prepare($query);
        $stmt->bindValue(':email', 'teste_cliente_fake' . ($contadorClientes + 1) . '@teste.com');
        
        if ($contadorClientes < 10) {
            $stmt->bindValue(':telefone_celular', '(14) 99899-650' . $contadorClientes);
            $stmt->bindValue(':telefone_complementar', '(14) 99899-650' . $contadorClientes);
            $stmt->bindValue(':telefone_fixo', '(14) 99899-650' . $contadorClientes);
        } else if ($contadorClientes < 100) {
            $stmt->bindValue(':telefone_celular', '(14) 99899-65' . $contadorClientes);
            $stmt->bindValue(':telefone_complementar', '(14) 99899-65' . $contadorClientes);
            $stmt->bindValue(':telefone_fixo', '(14) 99899-65' . $contadorClientes);
        } else {
            $stmt->bindValue(':telefone_celular', '(14) 99899-6' . $contadorClientes);
            $stmt->bindValue(':telefone_complementar', '(14) 99899-6' . $contadorClientes);
            $stmt->bindValue(':telefone_fixo', '(14) 99899-6' . $contadorClientes);
        }

        if ($contadorClientes % 2 == 0) {
            $stmt->bindValue(':tipo_pessoa', 'pf');
            $stmt->bindValue(':nome_completo', 'cliente ' . $contadorClientes);
            $stmt->bindValue(':data_nascimento', date('Y-m-d'));
            $stmt->bindValue(':sexo', $contadorClientes % 2 === 0 ? 'Masculino' : 'Feminino');

            if ($contadorClientes < 10) {
                $stmt->bindValue(':cpf', '123.456.789-0' . $contadorClientes);
            } else if ($contadorClientes < 100) {
                $stmt->bindValue(':cpf', '123.456.789-' . $contadorClientes);
            } else {
                $stmt->bindValue(':cpf', '123.456.' . $contadorClientes . '-12' . $contadorClientes);
            }

            $stmt->bindValue(':cnpj', null);
            $stmt->bindValue(':razao_social', null);
            $stmt->bindValue(':inscricao_estadual', null);
            $stmt->bindValue(':link_site', null);
        } else {
            $stmt->bindValue(':tipo_pessoa', 'pj');
            $stmt->bindValue(':razao_social', 'empresa ' . $contadorClientes . ' ltda');
            $stmt->bindValue(':inscricao_estadual', '123456');
            $stmt->bindValue(':link_site', null);

            if ($contadorClientes < 10) {
                $stmt->bindValue(':cnpj', '12.123.456/0001-0' . $contadorClientes);
            } else if ($contadorClientes < 100) {
                $stmt->bindValue(':cnpj', '12.123.456/0001-' . $contadorClientes);
            } else {
                $stmt->bindValue(':cnpj', '12.123.'. $contadorClientes .'/0001-01');
            }

            $stmt->bindValue(':cpf', null);
            $stmt->bindValue(':nome_completo', null);
            $stmt->bindValue(':data_nascimento', null);
            $stmt->bindValue(':sexo', null);
        }

        if ($stmt->execute()) {
            echo 'Cliente ' . $contadorClientes . ' cadastrado com sucesso!' . '</br>';
        } else {
            echo 'Cliente ' . $contadorClientes . ' não foi cadastrado com sucesso!' . '</br>';
        }

    }

}

function gerarCategoriasProdutosFake(PDO $bancoDados) {

    for ($contador = 0; $contador < 10000; $contador++) {
        $stmt = $bancoDados->prepare('INSERT INTO tb_categorias_produtos(descricao) VALUES(:descricao)');
        $stmt->bindValue(':descricao', 'categoria teste ' . $contador + 1);
        
        if ($stmt->execute()) {
            echo 'Categoria ' . $contador + 1 . ' registrada com sucesso!' . '</br>';
        } else {
            echo 'Categoria ' . $contador + 1 . ' não foi registrada com sucesso!' . '</br>';
        }

    }

}

function gerarProdutosFake(PDO $bancoDados) {

    for ($contador = 0; $contador < 1000; $contador++) {
        $urlFotoProd = 'https://i.imgur.com/gUoTryU.jpeg';

        $stmt = $bancoDados->prepare('INSERT INTO tb_produtos(
            nome_produto,
            codigo,
            status,
            preco_venda,
            preco_compra,
            unidades_estoque,
            url_foto,
            categoria_id,
            codigo_barras
        ) VALUES(
            :nome_produto,
            :codigo,
            :status,
            :preco_venda,
            :preco_compra,
            :unidades_estoque,
            :url_foto,
            :categoria_id,
            :codigo_barras
        )');

        $stmt->bindValue(':nome_produto', 'produto ' . $contador + 1);
        $stmt->bindValue(':codigo', $contador + 1);
        $stmt->bindValue(':url_foto', $urlFotoProd);
        $stmt->bindValue(':preco_venda', $contador + 10.23);
        $stmt->bindValue(':preco_compra', $contador + 2.50);
        $stmt->bindValue(':unidades_estoque', $contador + 100);
        $stmt->bindValue(':codigo_barras', md5($contador + 1));

        $status = rand(0, 1);

        if ($status == 0) {
            $status = true;
        } else {
            $status = false;
        }

        $stmt->bindValue(':status', $status, PDO::PARAM_BOOL);

        $idCategoria = 0;

        if ($contador < 100) {
            $idCategoria = 1001;
        } else if ($contador < 200) {
            $idCategoria = 1002;
        } else if ($contador < 300) {
            $idCategoria = 1003;
        } else if ($contador < 400) {
            $idCategoria = 1004;
        } else if ($contador < 500) {
            $idCategoria = 1005;
        } else {
            $idCategoria = 1006;
        }

        $stmt->bindValue(':categoria_id', $idCategoria);

        if ($stmt->execute()) {
            echo 'Produto ' . $contador + 1 . ' cadastrado com sucesso!</br>';
        } else {
            echo 'Produto ' . $contador + 1 . ' não foi cadastrado com sucesso!</br>';
        }

    }

}

try {
    $bancoDados = getConexaoBanco();
    
    if (!isset($_GET['operacao'])) {
        echo 'Informe a operação!</br>';
    } else {
        $operacao = trim($_GET['operacao']);

        switch ($operacao) {
            case 'clientes':
                gerarClientesFake($bancoDados);
                break;
            case 'categorias':
                gerarCategoriasProdutosFake($bancoDados);
                break;
            case 'produtos':
                gerarProdutosFake($bancoDados);
                break;
            default:
                echo 'Operação inválida</br>';
                break;
        }

    }

} catch (Exception $e) {
    echo 'Ocorreu o seguinte erro ao tentar-se gerar dados fakes: ' . $e->getMessage() . '</br>';
}
