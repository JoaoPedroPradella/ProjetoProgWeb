<?php

declare(strict_types=1);

namespace App\Models;

use DomainException;
use App\Models\BancoDeDados;

class Usuario {

    private BancoDeDados $bd;
      // Injeção de dependência para a classe BancoDeDados
      public function __construct(BancoDeDados $bd)
      {
          $this->bd = $bd;
      }

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

            $_SESSION['id'] = $dados['cd_usuario'];
            $_SESSION['nome'] = $dados['ds_usuario'];

            header('LOCATION: ../../sistema.php');
            exit();
        }
    }

    public static function deslogar(): void
    {
        session_start();
        session_destroy();

    }
    
    public function cadastrar(array $form): string
    {
        if ($form['id'] == 'NOVO') {
            $sql = 'INSERT INTO usuarios (ds_usuario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_senha, ds_nascimento, ds_situacao) VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)';
            $params = [
                $form['nome'],
                $form['cpf'],
                $form['email'],
                $form['cel'],
                $form['endereco'],
                $form['senha'],
                $form['nasc'],
                '1'
            ];
            $msg = 'Usuário cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE usuarios SET ds_usuario = ?, ds_cpf = ?, ds_email = ?, ds_celular = ?, ds_endereco = ?, ds_senha = ?, ds_nascimento = ?, ds_situacao = ? 
            WHERE cd_usuario = ?;';
            $params = [
                $form['nome'],
                $form['cpf'],
                $form['email'],
                $form['cel'],
                $form['endereco'],
                $form['senha'],
                $form['nasc'],
                $form['status'],
                $form['id']
            ];
            $msg = 'Usuário alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarUsuarios (string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_usuario, ds_usuario FROM usuarios ORDER BY cd_usuario DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_usuario, ds_usuario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_senha, ds_nascimento, ds_situacao FROM usuarios WHERE cd_usuario = ?';
        $params = [$id];
        $dados = $this->bd->selecionarRegistro($sql, $params);

        if (!empty($dados)) {
            // Retorne os dados como JSON válido
            return ($dados);
        } else {
            // Retorne uma mensagem de erro como JSON
            $msg = ('Registro não encontrado');
            return $msg;
        }
    }

    public function excluirUsuario(string $id): string
    {
            $sql = 'DELETE FROM usuarios WHERE cd_usuario = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Usuário excluído com sucesso!';
    }

    public function validaCPF( string $cpf): bool
    {
 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    
    }
 
}

