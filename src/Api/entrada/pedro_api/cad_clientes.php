<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Models\BancoDeDados;

// Validando se foi passado os parâmetros na URL
if ($_REQUEST["nome"] == '' || $_REQUEST["token"] == '' || $_REQUEST["nome"] == 'null' || $_REQUEST["token"] == 'null') {
    echo "<script>
    alert('Token ou nome inválido!')
    window.location.href = 'menu_pedro.php'
</script>";
    exit;
} else {
    $nome = $_REQUEST["nome"];
    $token = $_REQUEST["token"];
}

$json = file_get_contents("http://192.168.0.202/erp/json/buscaclientes.php?ds_nome=$nome&ds_token=$token");

// Validando o json
if ($json == '') {
    echo "<script>
        alert('Json não encontrado!')
        window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
    </script>";
    exit;
}

$obj = json_decode($json);
if (json_last_error() != 0) {
    echo 'OCORREU UM ERRO!</br>';
    switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            echo "<script>
                alert('Profundidade maxima excedida!')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo "<script>
                alert('Erro de sintaxe genérico!')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo "<script>
                alert('Caracter de controle encontrado!')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
        case JSON_ERROR_SYNTAX:
            echo "<script>
                alert('Erro de sintaxe! String JSON mal-formatado!')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
        case JSON_ERROR_UTF8:
            echo "<script>
                alert('Erro na codificação UTF-8')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
        default:
            echo "<script>
                alert('Erro desconhecido')
                window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
            </script>";
            break;
    }
}

if (count($obj) > 0) {
    echo "<script>
        alert('Json vazio ou com problemas!')
        window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
    </script>";
    exit;
}

$bd = new BancoDeDados('pedro_api');

$sql_select = 'SELECT * FROM clientes WHERE cd_cliente = ?';

$sql_update = 'UPDATE clientes SET nm_cliente = ?, ds_telefone = ?, ds_endereco = ?, ds_cpf_cnpj = ?, ds_bairro = ?, ds_cidade = ?, ds_uf = ?, nr_cep = ?, ds_status = ? WHERE cd_cliente = ?;';

$sql_insert = 'INSERT INTO clientes (cd_cliente, nm_cliente, ds_telefone, ds_endereco, ds_cpf_cnpj, ds_bairro, ds_cidade, ds_uf, nr_cep, ds_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

$i = 0;

foreach ($obj as $key => $value) {
    $params = [
        $cd_cliente[$i] = $value->cd_cliente
    ];
    $dados = $bd->selecionarRegistro($sql_select, $params);

    if (empty($dados)) {
        $params = [
            $cd_cliente[$i] = $value->cd_cliente,
            $nm_cliente[$i] = $value->nm_cliente,
            $ds_telefone[$i] = $value->ds_telefone,
            $ds_endereco[$i] = $value->ds_endereco,
            $ds_cpf_cnpj[$i] = $value->ds_cpf_cnpj,
            $ds_bairro[$i] = $value->ds_bairro,
            $ds_cidade[$i] = $value->ds_cidade,
            $ds_uf[$i] = $value->ds_uf,
            $nr_cep[$i] = $value->nr_cep,
            $ds_status[$i] = $value->ds_status
        ];

        $bd->executarComando($sql_insert, $params);
    } else {
        $params = [
            $nm_cliente[$i] = $value->nm_cliente,
            $ds_telefone[$i] = $value->ds_telefone,
            $ds_endereco[$i] = $value->ds_endereco,
            $ds_cpf_cnpj[$i] = $value->ds_cpf_cnpj,
            $ds_bairro[$i] = $value->ds_bairro,
            $ds_cidade[$i] = $value->ds_cidade,
            $ds_uf[$i] = $value->ds_uf,
            $nr_cep[$i] = $value->nr_cep,
            $ds_status[$i] = $value->ds_status,
            $cd_cliente[$i] = $value->cd_cliente
        ];

        $bd->executarComando($sql_update, $params);
    }
    $i++;
}

echo "<script>
    alert('Clientes cadastrados!')
    window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
</script>";
