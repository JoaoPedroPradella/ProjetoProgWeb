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

    public function listarVendas(string $id, string $tipo): mixed
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
        $sql = 'UPDATE vendas SET ds_situacao = ? WHERE cd_venda = ?';
        $params = ['Cancelada', $id];       
        $this->bd->executarComando($sql, $params);
        return 'Venda cancelada com sucesso!';
    }
}
