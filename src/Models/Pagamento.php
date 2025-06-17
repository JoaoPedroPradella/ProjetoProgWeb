<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class Pagamento
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
            $sql = 'INSERT INTO pagamentos (ds_pag) VALUES
            (?)';
            $params = [
                $form['desc'],
            ];
            $msg = 'Pagamento cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE pagamentos SET ds_pag = ?
            WHERE cd_pag = ?;';
            $params = [
                $form['desc'],
                $form['id']
            ];
            $msg = 'Pagamento alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarPagamentos(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_pag, ds_pag FROM pagamentos ORDER BY cd_pag DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_pag, ds_pag FROM pagamentos
        WHERE cd_pag = ?';
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

    public function excluirPagamento(string $id): string
    {
        $sql = 'SELECT count(cd_pag) AS pagamento FROM pagamentos p
        INNER JOIN pag_vendas v 
        ON p.cd_pag = v.cd_pagamento
        WHERE p.cd_pag = ?';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['pagamento'] == 0){
            $sql = 'DELETE FROM pagamentos WHERE cd_pag = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Pagamento excluido com sucesso!';
        } else{
            return 'Pagamento já em uso em vendas!';
            exit();
        }

    }
}
