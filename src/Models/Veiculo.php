<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class Veiculo
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
            $sql = 'INSERT INTO veiculos (ds_tipo, ds_placa, ds_cor, ds_situacao) VALUES
            (?, ?, ?, ?)';
            $params = [
                $form['tipo'],
                $form['placa'],
                $form['cor'],
                '1'
            ];
            $msg = 'Veículo cadastrado com sucesso!';
        } else {
            $sql = 'UPDATE veiculos SET ds_tipo = ?, ds_placa = ?, ds_cor = ?, ds_situacao = ?
            WHERE cd_veiculo = ?;';
            $params = [
                $form['tipo'],
                $form['placa'],
                $form['cor'],
                $form['status'],
                $form['id']
            ];
            $msg = 'Veículo alterado com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarVeiculos(string $id, string $tipo, string $situacao): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_veiculo, ds_tipo FROM veiculos WHERE ds_situacao = ? ORDER BY cd_veiculo DESC';
            $params = [$situacao];
            $dados = $this->bd->selecionarRegistros($sql, $params);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_veiculo, ds_tipo, ds_placa, ds_cor, ds_situacao FROM veiculos
        WHERE cd_veiculo = ?';
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

    public function excluirVeiculo(string $id): string
    {
        $sql = 'SELECT count(cd_veiculo) AS veiculo FROM vendas
        WHERE cd_veiculo = ? AND ds_situacao <> "Concluida"';
        $params = [$id];
        $resposta = $this->bd->selecionarRegistro($sql, $params);
        
        if($resposta['veiculo'] == 0){
            $sql = 'DELETE FROM veiculos WHERE cd_veiculo = ?';
            $params = [$id];
            $this->bd->executarComando($sql, $params);
            return 'Veículo excluido com sucesso!';
        } else{
            return 'Veículo já em uso em vendas!';
            exit();
        }

    }
}
