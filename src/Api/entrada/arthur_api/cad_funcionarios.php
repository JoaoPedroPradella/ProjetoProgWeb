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

$json = file_get_contents("http://192.168.0.209/ERP/json/usuarios_json.php?token=$token");

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

$sql_select = 'SELECT cd_funcionario FROM funcionarios WHERE cd_funcionario = ?;';

$sql_update = 'UPDATE funcionarios SET ds_funcionario = ?, ds_cpf = ?, ds_email = ?, ds_celular = ?, ds_endereco = ?, ds_senha = ?, dt_nascimento = ?, ds_situacao = ? WHERE cd_funcionario = ?;';

$sql_insert = 'INSERT INTO funcionarios (cd_funcionario, ds_funcionario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_senha, dt_nascimento, ds_situacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';

$i = 0;

foreach ($obj as $key => $value) {
    $params = [
        $cd_funcionario[$i] = $value->cd_funcionario
    ];
    $dados = $bd->selecionarRegistro($sql_select, $params);

    if (empty($dados)) {
        $params = [
            $cd_funcionario[$i] = $value->cd_funcionario,
            $ds_funcionario[$i] = $value->ds_funcionario,
            $ds_cpf[$i] = $value->ds_cpf,
            $ds_email[$i] = $value->ds_email,
            $ds_celular[$i] = $value->ds_celular,
            $ds_endereco[$i] = $value->ds_endereco,
            $ds_senha[$i] = $value->ds_senha,
            $dt_nascimento[$i] = $value->dt_nascimento,
            $ds_situacao[$i] = $value->ds_situacao
        ];

        $bd->executarComando($sql_insert, $params);
    } else {
        $params = [
            $ds_funcionario[$i] = $value->ds_funcionario,
            $ds_cpf[$i] = $value->ds_cpf,
            $ds_email[$i] = $value->ds_email,
            $ds_celular[$i] = $value->ds_celular,
            $ds_endereco[$i] = $value->ds_endereco,
            $ds_senha[$i] = $value->ds_senha,
            $dt_nascimento[$i] = $value->dt_nascimento,
            $ds_situacao[$i] = $value->ds_situacao,
            $cd_funcionario[$i] = $value->cd_funcionario
        ];

        $bd->executarComando($sql_update, $params);
    }
    $i++;
}

echo "<script>
    alert('Funcionários cadastrados!')
    window.location.href = 'menu_arthur.php?token=$token'
</script>";