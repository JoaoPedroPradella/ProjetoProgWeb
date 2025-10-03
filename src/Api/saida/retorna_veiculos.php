<?php
declare(strict_types=1);
use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);
session_start();


if (!isset($_SESSION['id'], $_SESSION['token'])) {
    // usuário não está logado, redireciona para login
    header('Location: ../cadastros/login_api.php');
    exit;
}

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;

$bd = new BancoDeDados();
// $cone = mysqli_connect("localhost", "root", "","sistema"); 
// mysqli_set_charset($cone, "utf8");

// $sql = "select * from usuarios where cd_usuario = " . $_REQUEST["cdu"] . " and ds_senha = '" . $_REQUEST["pwd"] . "'";
// $RSS = $bd->selecionarRegistro($sql);
// if (!isset($RSS["cd_usuario"])) {
//     echo "Usuario / Senha ERRADO";
//     exit();
// }

$linhas = array();
$rs = $bd->selecionarRegistros("select * from veiculos");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_veiculo' => $row['cd_veiculo'],
        'ds_placa' => $row['ds_placa'],
        'ds_tipo' => $row['ds_tipo'],
        'ds_cor' => $row['ds_cor'],
        'ds_situacao' => $row['ds_situacao']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
