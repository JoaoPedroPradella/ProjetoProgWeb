<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BancoDeDados;



class Categoria
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
            $sql = 'INSERT INTO categorias (ds_categoria) VALUES
            (?)';
            $params = [
                $form['desc'],
            ];
            $msg = 'Categoria cadastrada com sucesso!';
        } else {
            $sql = 'UPDATE categorias SET ds_categoria = ?
            WHERE cd_categoria = ?;';
            $params = [
                $form['desc'],
                $form['id']
            ];
            $msg = 'Categoria alterada com sucesso!';
        }
        $this->bd->executarComando($sql, $params);
        return $msg;
    }

    public function listarCategorias(string $id, string $tipo): mixed
    {
        if (!$tipo == '') {
            $sql = 'SELECT cd_categoria, ds_categoria FROM categorias ORDER BY cd_categoria DESC';
            $dados = $this->bd->selecionarRegistros($sql);
            return ($dados);
            exit();
        }
        $sql = 'SELECT cd_categoria, ds_categoria FROM categorias WHERE cd_categoria = ?';
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

    public function excluirCategoria (string $id): string
    {   
            $sql = 'SELECT COUNT(p.cd_categoria) as total FROM produtos p
            INNER JOIN categorias c
            ON p.cd_categoria = c.cd_categoria
            WHERE c.cd_categoria = ?';
            $params = [$id];
            $resposta = $this->bd->selecionarRegistro($sql, $params);

            if ($resposta['total'] == 0){
                $sql = 'DELETE FROM categorias WHERE cd_categoria = ?';
                $params = [$id];
                $this->bd->executarComando($sql, $params);
                return 'Categoria excluida com sucesso!';
            } else {
                return 'Categoria já vinculada com um ou mais produtos!';
            }

    }

}
