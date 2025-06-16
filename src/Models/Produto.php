<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class produto
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
            $sql = 'INSERT INTO produtos (ds_produto, cd_categoria, qt_estoque, vl_compra, vl_venda, ds_unidade, ds_situacao) VALUES
            (?, ?, ?, ?, ?, ?, ?)';
            $params = [
                $form['desc'],
                $form['categ'],
                $form['qtd'],
                $form['custo'],
                $form['preco'],
                $form['und'],
                '1'
            ];
            $msg = 'Produto cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE produtos SET ds_produto = ?, cd_categoria = ?, qt_estoque = ?, vl_compra = ?, vl_venda = ?, ds_unidade = ?, ds_situacao = ?
            WHERE cd_produto = ?;';
            $params = [
                $form['desc'],
                $form['categ'],
                $form['qtd'],
                $form['custo'],
                $form['preco'],
                $form['und'],
                $form['status'],
                $form['id']
            ];
            $msg = 'Produto alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarProdutos(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_produto, ds_produto FROM produtos ORDER BY cd_produto DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT p.cd_produto, p.ds_produto, c.cd_categoria, c.ds_categoria, p.qt_estoque, p.vl_compra, p.vl_venda, p.ds_unidade, p.ds_situacao FROM produtos p
        INNER JOIN categorias c 
        ON p.cd_categoria = c.cd_categoria
        WHERE cd_produto = ?';
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

    public function excluirProduto(string $id): string
    {
        $sql = 'SELECT count(cd_produto) AS produto FROM ite_vendas i 
        INNER JOIN vendas v
        ON i.cd_venda = v.cd_venda
        WHERE cd_produto = ? AND v.ds_situacao <> "Concluida"';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['produto'] == 0){
            $sql = 'DELETE FROM produtos WHERE cd_produto = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Produto excluido com sucesso!';
        } else{
            return 'Produto já em uso em vendas!';
            exit();
        }

    }
}
