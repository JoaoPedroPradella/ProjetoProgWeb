<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;

class Cliente
{
    private BancoDeDados $bd;

    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(array $form): string
    {
        if ($form['id'] == 'NOVO') {
            $sql = 'INSERT INTO clientes (ds_nome, ds_cpf_cnpj, ds_tel, ds_cep, ds_uf, ds_municipio, ds_logradouro, tp_tipo) VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)';
            $params = [
                $form['nome'],
                $form['cpf_cnpj'],
                $form['telefone'],
                $form['cep'],
                $form['uf'],
                $form['munic'],
                $form['lograd'],
                '1'
            ];
            $msg = 'Cliente cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE clientes SET ds_nome = ?, ds_cpf_cnpj = ?, ds_tel = ?, ds_cep = ?, ds_uf = ?, ds_municipio = ?, ds_logradouro = ?, tp_tipo = ? 
            WHERE cd_cliente = ?;';
            $params = [
                $form['nome'],
                $form['cpf_cnpj'],
                $form['telefone'],
                $form['cep'],
                $form['uf'],
                $form['munic'],
                $form['lograd'],
                '1',
                $form['id']
            ];
            $msg = 'Cliente alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarClientes(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_cliente, ds_nome FROM clientes ORDER BY cd_cliente DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_cliente, ds_nome, ds_cpf_cnpj, ds_tel, ds_cep, ds_uf, ds_municipio, ds_logradouro, tp_tipo FROM clientes WHERE cd_cliente = ?';
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

    public function excluirCliente(string $id): string
    {
        $sql = 'SELECT count(clienteid) AS cliente FROM venda WHERE clienteid = ?';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['cliente'] == 0){
            $sql = 'DELETE FROM cliente WHERE id = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Cliente excluido com sucesso!';
        } else{
            return 'Cliente já em uso em vendas!';
            exit();
        }

    }
}
