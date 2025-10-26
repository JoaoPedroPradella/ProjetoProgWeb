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

$json = file_get_contents("http://192.168.0.202/erp/json/buscaveiculos.php?ds_nome=$nome&ds_token=$token");

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

$sql_select = 'SELECT * FROM veiculos WHERE cd_veiculo = ?;';

$sql_update = 'UPDATE veiculos SET ds_tipo = ?, ds_placa = ?, ds_cor = ?, ds_situacao = ? WHERE cd_veiculo = ?;';

$sql_insert = 'INSERT INTO veiculos (cd_veiculo, ds_tipo, ds_placa, ds_cor, ds_situacao) VALUES (?, ?, ?, ?, ?)';


$i = 0;

foreach ($obj as $key => $value) {
    $params = [
        $cd_veiculo[$i] = $value->cd_veiculo
    ];
    $dados = $bd->selecionarRegistro($sql_select, $params);

    if (empty($dados)) {
        $params = [
            $cd_veiculo[$i] = $value->cd_veiculo,
            $ds_tipo[$i] = $value->ds_tipo,
            $ds_placa[$i] = $value->ds_placa,
            $ds_cor[$i] = $value->ds_cor,
            $ds_situacao[$i] = $value->ds_situacao,
        ];

        $bd->executarComando($sql_insert, $params);
    } else {
        $params = [
            $ds_tipo[$i] = $value->ds_tipo,
            $ds_placa[$i] = $value->ds_placa,
            $ds_cor[$i] = $value->ds_cor,
            $ds_situacao[$i] = $value->ds_situacao,
            $cd_veiculo[$i] = $value->cd_veiculo
        ];

        $bd->executarComando($sql_update, $params);
    }
    $i++;
}

echo "<script>
    alert('Veículos cadastrados!')
    window.location.href = 'menu_pedro.php?nome=$nome&token=$token'
</script>";