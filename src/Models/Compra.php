<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use App\Models\BancoDeDados;

class Compra
{

    private BancoDeDados $bd;
    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(array $form, array $dadosItens, array $dadosPagamentos): string
    {
        $sql = 'INSERT INTO compras (dt_emissao, dt_entrada, vl_total, vl_frete, cd_cliente, cd_veiculo) VALUES
        (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, ?, ?, ?, ?)';
        $params = [
            $form['valTotal'],
            $form['frete'],
            $form['cliente'],
            $form['veiculo']
        ];

        $this->bd->executarComando($sql, $params);

        $sql = 'SELECT MAX(cd_compra) AS max_compra FROM compras';

        $dados = $this->bd->selecionarRegistros($sql);

        $numCompra = $dados[0]['max_compra'] ?? null;

        if (!$numCompra) {
            throw new Exception('Erro ao obter o número da compra.');
        }

        foreach ($dadosItens as $item) {
                $sql = 'INSERT INTO ite_compras (ds_produto, vl_uni, qt_compra, vl_desc, vl_total, cd_produto, cd_compra) VALUES (?, ?, ?, ?, ?, ?, ?)';

                $params = [
                    $item['desc'],  // Descrição do item
                    $item['prec'],  // Preço do item
                    $item['qtd'],  // Quantidade do item
                    $item['desconto'],  // Desconto do item
                    $item['total_item'],  // Valor total do item
                    $item['idItem'],  // Código do item
                    $numCompra, // Código da compra
                ];

            $this->bd->executarComando($sql, $params);
        }

        foreach ($dadosItens as $item) {
                $sql = 'UPDATE produtos SET qt_estoque = qt_estoque + ? WHERE cd_produto=?';

                $params = [
                    $item['qtd'],  // Quantidade do item
                    $item['idItem'],  // Código do item
                ];

                $this->bd->executarComando($sql, $params);
        }

        foreach ($dadosPagamentos as $pagamento) {
            $sql = 'INSERT INTO pag_compras (vl_pagamento, cd_compra, cd_pagamento) VALUES (?, ?, ?)';

            $params = [
                $pagamento['val_pago'],  // Valor Pago
                $numCompra,
                $pagamento['idPag'],  // ID Pagamento 
            ];

            $this->bd->executarComando($sql, $params);
        }


        $msg = 'compra cadastrada com sucesso!';

        return $msg;
    }

    public function listarCompras(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_compra, dt_emissao, dt_entrada, vl_total, vl_frete, cd_cliente, cd_veiculo FROM compras ORDER BY cd_compra DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        // COMPRAS
        $sql = 'SELECT cp.cd_compra, c.ds_nome as cliente, vec.ds_tipo, cp.vl_frete, cp.cd_veiculo, cp.cd_cliente, cp.vl_total FROM compras cp 
                INNER JOIN clientes c
                ON cp.cd_cliente = c.cd_cliente
                INNER JOIN veiculos vec
                ON cp.cd_veiculo = vec.cd_veiculo 
                WHERE cp.cd_compra = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistro($sql, $params);

        // ITECOMPRAS
        $sql = 'SELECT i.cd_produto, i.ds_produto, i.qt_compra, i.vl_uni, i.vl_desc, i.vl_total FROM compras cp 
                INNER JOIN ite_compras i 
                ON cp.cd_compra = i.cd_compra
                WHERE cp.cd_compra = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistros($sql, $params);

        // PAGAMENTOS
        $sql = 'SELECT pag.ds_pag, p.vl_pagamento FROM compras cp 
                INNER JOIN pag_compras p
                ON cp.cd_compra = p.cd_compra
                INNER JOIN pagamentos pag
                ON p.cd_pagamento = pag.cd_pag 
                WHERE cp.cd_compra = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistros($sql, $params);


        if (!empty($dados)) {
            // Retorne os dados como JSON válido
            return ($dados);
        } else {
            // Retorne uma mensagem de erro como JSON
            $msg = ('Registro não encontrado');
            return $msg;
        }
    }

    public function cancelarcompra(string $id): string
    {
        $sql = 'UPDATE compras SET ds_situacao = ? WHERE cd_compra = ?';
        $params = ['Cancelada', $id];
        $this->bd->executarComando($sql, $params);
        return 'compra cancelada com sucesso!';
    }
}
