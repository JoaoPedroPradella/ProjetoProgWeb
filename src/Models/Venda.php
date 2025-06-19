<?php

declare(strict_types=1);

namespace App\Models;

use DomainException;
use App\Models\BancoDeDados;

class Venda {

    private BancoDeDados $bd;
      // Injeção de dependência para a classe BancoDeDados
      public function __construct(BancoDeDados $bd)
      {
          $this->bd = $bd;
      }
    
    public function cadastrar(array $form): string 
    {
        if ($form['id'] == 'NOVO') {
            $sql = 'INSERT INTO vendas (ds_usuario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_senha, ds_nascimento, ds_situacao) VALUES
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
            $sql = 'UPDATE vendas SET ds_usuario = ?, ds_cpf = ?, ds_email = ?, ds_celular = ?, ds_endereco = ?, ds_senha = ?, ds_nascimento = ?, ds_situacao = ? 
            WHERE cd_venda = ?;';
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

    public function listarVendas (string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_venda, dt_emissao, vl_frete, vl_total, ds_situacao,  cd_vendedor, cd_veiculo, cd_cliente FROM vendas ORDER BY cd_venda DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT dt_emissao, vl_frete, vl_total, ds_situacao,  cd_vendedor, cd_veiculo, cd_cliente FROM vendas WHERE cd_venda = ?';
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

    public function cancelarVenda(string $id): string
    {
            $sql = 'DELETE FROM vendas WHERE cd_venda = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Usuário excluído com sucesso!';
    }
}

