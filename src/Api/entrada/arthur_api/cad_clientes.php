<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Models\BancoDeDados;

// Validando se foi passado os parâmetros na URL
if ($_REQUEST["token"] == '' || $_REQUEST["token"] == 'null') {
    echo "<script>
        alert('Token inválido!')
        window.location.href = 'menu_arthur.php'
    </script>";
    exit;
} else {
    $token = $_REQUEST["token"];
}

$json = file_get_contents("http://192.168.0.209/ERP/json/clientes_json.php?token=$token");

// Validando o json
if ($json == '') {
    echo "<script>
        alert('Json não encontrado!')
        window.location.href = 'menu_arthur.php?token=$token'
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
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo "<script>
                alert('Erro de sintaxe genérico!')
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo "<script>
                alert('Caracter de controle encontrado!')
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
        case JSON_ERROR_SYNTAX:
            echo "<script>
                alert('Erro de sintaxe! String JSON mal-formatado!')
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
        case JSON_ERROR_UTF8:
            echo "<script>
                alert('Erro na codificação UTF-8')
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
        default:
            echo "<script>
                alert('Erro desconhecido')
                window.location.href = 'menu_arthur.php?token=$token'
            </script>";
            break;
    }
}

if (count($obj) > 0) {
    echo "<script>
        alert('Json vazio ou com problemas!')
        window.location.href = 'menu_arthur.php?token=$token'
    </script>";
    exit;
}

$bd = new BancoDeDados('arthur_api');

$sql_select = 'SELECT id FROM clientes WHERE id = ?;';

$sql_update = 'UPDATE clientes SET nome_cliente = ?, cpf_cliente = ?, email_cliente = ?, celular_cliente = ?, endereco_cliente = ?, data_nascimento_cliente = ?, data_cadastro = ? WHERE id = ?;';

$sql_insert = 'INSERT INTO clientes (id, nome_cliente, cpf_cliente, email_cliente, celular_cliente, endereco_cliente, data_nascimento_cliente, data_cadastro) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';

$i = 0;

foreach ($obj as $key => $value) {
    $params = [
        $id[$i] = $value->id
    ];
    $dados = $bd->selecionarRegistro($sql_select, $params);

    if (empty($dados)) {
        $params = [
            $id[$i] = $value->id,
            $nome_cliente[$i] = $value->nome_cliente,
            $cpf_cliente[$i] = $value->cpf_cliente,
            $email_cliente[$i] = $value->email_cliente,
            $celular_cliente[$i] = $value->celular_cliente,
            $endereco_cliente[$i] = $value->endereco_cliente,
            $data_nascimento_cliente[$i] = $value->data_nascimento_cliente,
            $data_cadastro[$i] = $value->data_cadastro
        ];

        $bd->executarComando($sql_insert, $params);
    } else {
        $params = [
            $nome_cliente[$i] = $value->nome_cliente,
            $cpf_cliente[$i] = $value->cpf_cliente,
            $email_cliente[$i] = $value->email_cliente,
            $celular_cliente[$i] = $value->celular_cliente,
            $endereco_cliente[$i] = $value->endereco_cliente,
            $data_nascimento_cliente[$i] = $value->data_nascimento_cliente,
            $data_cadastro[$i] = $value->data_cadastro,
            $id[$i] = $value->id
        ];

        $bd->executarComando($sql_update, $params);
    }
    $i++;
}

echo "<script>
    alert('Clientes cadastrados!')
    window.location.href = 'menu_arthur.php?token=$token'
</script>";