<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use App\Models\BancoDeDados;

class Venda
{

    private BancoDeDados $bd;
    // Injeção de dependência para a classe BancoDeDados
    public function __construct(BancoDeDados $bd)
    {
        $this->bd = $bd;
    }

    public function cadastrar(array $form, array $dadosItens, array $dadosPagamentos): string
    {
        $sql = 'INSERT INTO vendas (dt_emissao, vl_frete, vl_total, ds_situacao, cd_vendedor, cd_veiculo, cd_cliente) VALUES
        (CURRENT_TIMESTAMP, ?, ?, ?, ?, ?, ?)';
        $params = [
            $form['frete'],
            $form['valTotal'],
            'Concluida',
            $form['vendedor'],
            $form['veiculo'],
            $form['cliente']
        ];

        $this->bd->executarComando($sql, $params);

        $sql = 'SELECT MAX(cd_venda) AS max_venda FROM vendas';

        $dados = $this->bd->selecionarRegistros($sql);

        $numVenda = $dados[0]['max_venda'] ?? null;

        if (!$numVenda) {
            throw new Exception('Erro ao obter o número da venda.');
        }

        foreach ($dadosItens as $item) {
            if ($item['tipo_item'] == 'produto') {
                $sql = 'INSERT INTO ite_vendas (ds_produto, vl_uni, qt_venda, vl_desc, vl_total, cd_venda, cd_produto, cd_vendedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

                $params = [
                    $item['desc'],  // Descrição do item
                    $item['prec'],  // Preço do item
                    $item['qtd'],  // Quantidade do item
                    $item['desconto'],  // Desconto do item
                    $item['total_item'],  // Valor total do item
                    $numVenda, // Código da venda
                    $item['idItem'],  // Código do item
                    $item['id_vendedor'], // Código do vendedor

                ];
            } else {
                $sql = 'INSERT INTO ser_vendas (ds_servico, vl_hora, qt_hora, vl_desc, vl_total, cd_venda, cd_servico) VALUES (?, ?, ?, ?, ?, ?, ?)';

                $params = [
                    $item['desc'],  // Descrição do item
                    $item['prec'],  // Preço do item
                    $item['qtd'],  // Quantidade do item
                    $item['desconto'],  // Desconto do item
                    $item['total_item'],  // Valor total do item
                    $numVenda, // Código da venda
                    $item['idItem'],  // Código do item
                ];
            }


            $this->bd->executarComando($sql, $params);
        }

        foreach ($dadosItens as $item) {
            if ($item['tipo_item'] == 'produto') {
                $sql = 'UPDATE produtos SET qt_estoque = qt_estoque - ? WHERE cd_produto=?';

                $params = [
                    $item['qtd'],  // Quantidade do item
                    $item['idItem'],  // Código do item
                ];

                $this->bd->executarComando($sql, $params);
            }
        }

        foreach ($dadosPagamentos as $pagamento) {
            $sql = 'INSERT INTO pag_vendas (vl_pagamento, cd_venda, cd_pagamento) VALUES (?, ?, ?)';

            $params = [
                $pagamento['val_pago'],  // Valor Pago
                $numVenda,
                $pagamento['idPag'],  // ID Pagamento 
            ];

            $this->bd->executarComando($sql, $params);
        }


        $msg = 'Venda cadastrada com sucesso!';

        return $msg;
    }

    public function listarVendas(string $id, string $tipo, string $situacao): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_venda, dt_emissao, vl_frete, vl_total, ds_situacao,  cd_vendedor, cd_veiculo, cd_cliente FROM vendas WHERE ds_situacao = ? ORDER BY cd_venda DESC';
            $params = [$situacao];
            $dados = $this->bd->selecionarRegistros($sql, $params);
            return ($dados);
            exit();
        }
        // VENDAS
        $sql = 'SELECT v.cd_venda, c.ds_nome as cliente, vec.ds_tipo, v.vl_frete, vend.ds_nome as vendedor, v.cd_vendedor, v.cd_veiculo, v.cd_cliente, vl_total FROM vendas v 
                INNER JOIN clientes c
                ON v.cd_cliente = c.cd_cliente
                INNER JOIN veiculos vec
                ON v.cd_veiculo = vec.cd_veiculo 
                INNER JOIN vendedores vend
                ON v.cd_vendedor = vend.cd_vendedor
                WHERE v.cd_venda = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistro($sql, $params);

        // ITEVENDAS
        $sql = 'SELECT i.cd_produto, i.ds_produto, i.qt_venda, i.vl_uni, i.vl_desc, vend.ds_nome, i.vl_total FROM vendas v 
                INNER JOIN ite_vendas i 
                ON v.cd_venda = i.cd_venda
                INNER JOIN vendedores vend
                ON v.cd_vendedor = vend.cd_vendedor
                WHERE v.cd_venda = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistros($sql, $params);

        // SERVENDAS
        $sql = 'SELECT s.cd_servico, s.ds_servico, s.vl_hora, s.qt_hora, s.vl_desc, s.vl_total FROM vendas v 
                INNER JOIN ser_vendas s
                ON v.cd_venda = s.cd_venda
                WHERE v.cd_venda = ?';
        $params = [$id];
        $dados[] = $this->bd->selecionarRegistros($sql, $params);

        // PAGAMENTOS
        $sql = 'SELECT pag.ds_pag, p.vl_pagamento FROM vendas v 
                INNER JOIN pag_vendas p
                ON v.cd_venda = p.cd_venda
                INNER JOIN pagamentos pag
                ON p.cd_pagamento = pag.cd_pag 
                WHERE v.cd_venda = ?';
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

    public function cancelarVenda(string $id, array $dadosItens): string
    {
        $sql = 'UPDATE vendas SET ds_situacao = ? WHERE cd_venda = ?';
        $params = ['Cancelada', $id];
        $this->bd->executarComando($sql, $params);

        if (!empty($dadosItens)){
            foreach ($dadosItens as $item) {
                $sql = 'UPDATE produtos SET qt_estoque = qt_estoque + ? WHERE cd_produto=?';

                $params = [
                    $item['qtd'],  // Quantidade do item
                    $item['id'],  // Código do item
                ];

                $this->bd->executarComando($sql, $params);
            }
        }

        return 'Venda cancelada com sucesso!';
    }
}
