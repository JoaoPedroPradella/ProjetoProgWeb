<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class Vendedor
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
            $sql = 'INSERT INTO vendedores (ds_nome) VALUES
            (?)';
            $params = [
                $form['nome'],
            ];
            $msg = 'Vendedor cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE vendedores SET ds_nome = ?
            WHERE cd_vendedor = ?;';
            $params = [
                $form['nome'],
                $form['id']
            ];
            $msg = 'Vendedor alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarVendedores(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_vendedor, ds_nome FROM vendedores ORDER BY cd_vendedor DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_vendedor, ds_nome FROM vendedores
        WHERE cd_vendedor = ?';
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

    public function excluirVendedor(string $id): string
    {
        $sql = 'SELECT count(cd_vendedor) AS vendedor FROM ite_vendas i 
        INNER JOIN vendas v
        ON i.cd_venda = v.cd_venda
        WHERE cd_vendedor = ? AND v.ds_situacao <> "Concluida"';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['vendedor'] == 0){
            $sql = 'DELETE FROM vendedores WHERE cd_vendedor = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Vendedor excluido com sucesso!';
        } else{
            return 'Vendedor já em uso em vendas!';
            exit();
        }

    }
}
