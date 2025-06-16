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
                $form['status'],
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
        $sql = 'SELECT count(cd_cliente) AS cliente FROM vendas WHERE cd_cliente = ?';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['cliente'] == 0){
            $sql = 'DELETE FROM clientes WHERE cd_cliente = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Cliente excluido com sucesso!';
        } else{
            return 'Cliente já em uso em vendas!';
            exit();
        }

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
    
    public function validarCNPJ(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
    
        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;	
    
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
    
        $resto = $soma % 11;
    
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;
    
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
    
        $resto = $soma % 11;
    
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

}
