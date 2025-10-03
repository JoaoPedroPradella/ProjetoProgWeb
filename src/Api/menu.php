<?php
declare(strict_types=1);
use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);
session_start();


if (!isset($_SESSION['id'], $_SESSION['token'])) {
    // usuário não está logado, redireciona para login
    header('Location: cadastros/login_api.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Menu - API JAO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

        h1, h2, h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        ul {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>API JAO</h1>

    <h2>Entidades Disponíveis:</h2>
    <ul>
        <li>Clientes</li>
        <li>Produtos</li>
        <li>Serviços</li>
        <li>Veículos</li>
        <li>Vendedores</li>
        <li>Categorias</li>
        <li>Vendas</li>
    </ul>

    <h2>Formato de Retorno:</h2>
    <p>Em todas as consultas será retornado um arquivo no formato <strong>JSON</strong>.</p>

    <h2>Funcionalidades:</h2>
    <ul>
        <li>Cadastro de usuários para acesso</li>
        <li>Controle de acesso por usuário</li>
        <li>Controle de acesso por token</li>
        <li>Controle de log</li>
        <li>Gestão de CRUD</li>
        <li>Relatórios de acesso</li>
    </ul>

    <!-- 1 - Clientes -->
    <h2>1. Entidade: Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_cliente</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_nome</td><td>varchar</td><td>255</td><td>not null</td></tr>
            <tr><td>ds_cpf_cnpj</td><td>varchar</td><td>14</td><td>-</td></tr>
            <tr><td>ds_tel</td><td>varchar</td><td>20</td><td>-</td></tr>
            <tr><td>ds_cep</td><td>varchar</td><td>8</td><td>not null</td></tr>
            <tr><td>ds_uf</td><td>varchar</td><td>2</td><td>not null</td></tr>
            <tr><td>ds_municipio</td><td>varchar</td><td>200</td><td>not null</td></tr>
            <tr><td>ds_logradouro</td><td>varchar</td><td>100</td><td>not null</td></tr>
            <tr><td>tp_tipo</td><td>char</td><td>-</td><td>not null</td></tr>
        </tbody>
    </table>
    
    <a href="saida\retorna_clientes.php"><button>Consultar Clientes</button></a>

    <!-- 2 - Produtos -->
    <h2>2. Entidade: Produtos</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_produto</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_produto</td><td>varchar</td><td>255</td><td>not null</td></tr>
            <tr><td>cd_categoria</td><td>int</td><td>-</td><td>-</td></tr>
            <tr><td>qt_estoque</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>vl_compra</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>vl_venda</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>ds_unidade</td><td>varchar</td><td>5</td><td>-</td></tr>
            <tr><td>ds_situacao</td><td>char</td><td>-</td><td>not null</td></tr>
        </tbody>
    </table>

    <a href="saida\retorna_produtos.php"><button>Consultar Produtos</button></a>

    <!-- 3 - Serviços -->
    <h2>3. Entidade: Serviços</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_servico</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_servico</td><td>varchar</td><td>255</td><td>not null</td></tr>
            <tr><td>vl_hora</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>vl_minimo</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>tp_tipo</td><td>varchar</td><td>100</td><td>-</td></tr>
            <tr><td>ds_situacao</td><td>char</td><td>-</td><td>not null</td></tr>
        </tbody>
    </table>

    <a href="saida\retorna_servicos.php"><button>Consultar Serviços</button></a>

    <!-- 4 - Veículos -->
    <h2>4. Entidade: Veículos</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_veiculo</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_placa</td><td>int</td><td>-</td><td>not null</td></tr>
            <tr><td>ds_tipo</td><td>varchar</td><td>100</td><td>not null</td></tr>
            <tr><td>ds_cor</td><td>varchar</td><td>50</td><td>not null</td></tr>
            <tr><td>ds_situacao</td><td>char</td><td>-</td><td>not null</td></tr>
        </tbody>
    </table>

    <p><strong>Exemplo de chamada:</strong> Para acessar a entidade de veículos basta acessar o link: <em>(Em produção)</em></p>

       <!-- 5 - Vendedores -->
       <h2>5. Entidade: Vendedores</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_vendedor</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_nome</td><td>varchar</td><td>255</td><td>not null</td></tr>
        </tbody>
    </table>

    <a href="saida\retorna_veiculos.php"><button>Consultar Veículos</button></a>

    <!-- 6 - Categorias -->
    <h2>6. Entidade: Categorias</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_categoria</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>ds_categoria</td><td>varchar</td><td>100</td><td>not null</td></tr>
        </tbody>
    </table>

    <a href="saida\retorna_categorias.php"><button>Consultar Categorias</button></a>

    <!-- 7 - Vendas -->
    <h2>7. Entidade: Vendas</h2>
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Tamanho</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>cd_venda</td><td>int</td><td>-</td><td>not null, auto_increment, primary key</td></tr>
            <tr><td>dt_emissao</td><td>varchar</td><td>20</td><td>not null</td></tr>
            <tr><td>vl_frete</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>vl_total</td><td>float</td><td>-</td><td>not null</td></tr>
            <tr><td>ds_situacao</td><td>varchar</td><td>50</td><td>not null</td></tr>
            <tr><td>cd_vendedor</td><td>int</td><td>-</td><td>-</td></tr>
            <tr><td>cd_veiculo</td><td>int</td><td>-</td><td>-</td></tr>
            <tr><td>cd_cliente</td><td>int</td><td>-</td><td>-</td></tr>
        </tbody>
    </table>

    <a href="saida\retorna_vendas.php"><button>Consultar Vendas</button></a>

</body>
</html>