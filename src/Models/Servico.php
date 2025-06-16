<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class Servico
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
            $sql = 'INSERT INTO servicos (ds_servico, vl_hora, vl_minimo, tp_tipo, ds_situacao) VALUES
            (?, ?, ?, ?, ?)';
            $params = [
                $form['desc'],
                $form['vlhr'],
                $form['vlmin'],
                $form['tipo'],
                '1'
            ];
            $msg = 'Servico cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE servicos SET ds_servico = ?, vl_hora = ?, vl_minimo = ?, tp_tipo = ?, ds_situacao = ?
            WHERE cd_servico = ?;';
            $params = [
                $form['desc'],
                $form['vlhr'],
                $form['vlmin'],
                $form['tipo'],
                $form['status'],
                $form['id']
            ];
            $msg = 'Servico alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarServicos(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_servico, ds_servico FROM servicos ORDER BY cd_servico DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_servico, ds_servico, vl_hora, vl_minimo, tp_tipo, ds_situacao FROM servicos p
        WHERE cd_servico = ?';
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

    public function excluirServico(string $id): string
    {
        $sql = 'SELECT count(cd_servico) AS servico FROM ser_vendas s 
        INNER JOIN vendas v
        ON s.cd_venda = v.cd_venda
        WHERE cd_servico = ? AND v.ds_situacao <> "Concluida"';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['servico'] == 0){
            $sql = 'DELETE FROM servicos WHERE cd_servico = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Servico excluido com sucesso!';
        } else{
            return 'Servico já em uso em vendas!';
            exit();
        }

    }
}
