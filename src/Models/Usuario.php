<?php

declare(strict_types=1);

namespace App\Models;

use DomainException;
use App\Models\BancoDeDados;

class Usuario {
    public static function validarEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
            exit();
        }
        return false;
    }

    public static function login(string $email, string $senha): void
    {
        $bd = new BancoDeDados;
        $sql = 'SELECT cd_usuario, ds_usuario FROM usuarios
        WHERE ds_email = ? AND ds_senha = ?';
        $params = [$email, $senha];
        $dados = $bd->selecionarRegistro($sql, $params);

        if ($dados['cd_usuario'] == null) {
            echo   "<script>
                        alert('E-mail ou senha inválidos!')
                        window.location.href = '../../index.php'
                    </script>";

            exit();
        } else {
            session_set_cookie_params(['httponly' => true]);
            session_start();
            session_regenerate_id(true);

            $_SESSION['id'] = $dados['id'];
            $_SESSION['nome'] = $dados['nome'];

            header('LOCATION: ../../sistema.php');
            exit();
        }
    }

    public static function deslogar(): void
    {
        session_start();
        session_destroy();
    }
}

