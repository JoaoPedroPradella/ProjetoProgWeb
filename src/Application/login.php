<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Usuario;

$email    = isset($_POST['txt_email'])  ? $_POST['txt_email']     : '';
$senha      = isset($_POST['txt_senha'])    ? $_POST['txt_senha']       : '';


if ($email == '' || $senha == '') {
    echo "<script>
        alert('E-mail ou Senha vazios. Verifique!');
        window.location = '../login.php';
    </script>";
    exit;
}

// Verificando se é um e-mail válido
if (Usuario::validarEmail($email)) {
    echo   "<script>
        alert('Esse e-mail não é um e-mail válido!')
        window.location.href = '../../index.php'
    </script>";
} else {
    Usuario::login($email, $senha);
}

