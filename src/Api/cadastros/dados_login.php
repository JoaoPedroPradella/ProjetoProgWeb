<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Usuario;

$email    = isset($_POST['txt_email'])  ? $_POST['txt_email']     : '';
$token      = isset($_POST['txt_token'])    ? $_POST['txt_token']       : '';


if ($email == '' || $token == '') {
    echo "<script>
        alert('E-mail ou Token vazios. Verifique!');
        window.location = 'login_api.php';
    </script>";
    exit;
}


Usuario::login_api($email, $token);

