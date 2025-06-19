<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>List groups · Bootstrap v5.3</title>
    <link rel="stylesheet" href="assets\css\menu.css">
</head>

<body>
    <main id="main_venda">
        <h1>Vendas</h1>
        <table>
            <tbody id="lista">
                <tr>
                </tr>
                <!-- Linhas serão adicionadas dinamicamente aqui -->
            </tbody>
        </table>
        <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><button onclick="alterarCadastro()" class="nav-link px-2 text-body-secondary" id="btn_editar" name="btn_editar">Editar</button></li>
                    <li class="nav-item"><button onclick="alterarCadastro()" class="nav-link px-2 text-body-secondary" id="btn_detalhes" name="btn_detalhes">Detalhes</button></li>
                    <li class="nav-item"><button onclick class="nav-link px-2 text-body-secondary" id="btn_exc" name="btn_exc">Excluir</button></li>
                </ul>
                <ul class="nav justify-content-center">
                    <li class="nav-item"><button id="btn_novo" id="btn_novo">NOVO</button></li>
                </ul>
            </footer>
        </div>

        <dialog id="modal_venda">
            <div class="modal position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
                <div>
                    <div>
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <h1 class="fw-bold mb-0 fs-2" id="txt_titulo"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="btn_fechar"></button>
                        </div>

                        <div class="modal-body p-5 pt-0">
                            <form class="" id="form">
                                <div class="form-floating mb-3">
                                    <input type="text" id="txt_id" name="txt_id" value="NOVO"
                                        style="background-color: rgba(128, 128, 128, 0.103); font: bolder;" readonly
                                        class="form-control rounded-3">
                                    <label for="floatingInput">Codigo</label>
                                </div>
                                <div class="form-floating mb-3" id="dv_cliente">
                                    <select name="slc_cliente" class="form-control rounded-3" id="slc_cliente">
                                        <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                    </select>
                                    <label for="floatingPassword">Cliente</label>
                                </div>
                                <div id="transporte">
                                    <div class="form-floating mb-3" id="dv_veiculo">
                                        <select name="slc_veiculo" class="form-control rounded-3" id="slc_veiculo">
                                            <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                        </select>
                                        <label for="floatingPassword">Veículos</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input input type="number" id="txt_frete" name="txt_frete" required class="form-control rounded-3">
                                        <label for="floatingPassword">Frete</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3" id="dv_vendedor">
                                    <select name="slc_vendedor" class="form-control rounded-3" id="slc_vendedor">
                                        <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                    </select>
                                    <label for="floatingPassword">Vendedor</label>
                                </div>
                                <div id="prod_serv">
                                    <div class="form-floating mb-3" id="dv_item">
                                        <select name="slc_item" class="form-control rounded-3" id="slc_item">
                                            <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                        </select>
                                        <label for="floatingPassword">Item</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <div>
                                            <input type="checkbox" id="chk_tipo" name="chk_tipo">
                                            <label for="chk_tipo">Serviço</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="vl_qtd">
                                    <div class="form-floating mb-3" id="dv_vlu">
                                        <input input type="number" id="txt_qtd" name="txt_qtd" required class="form-control rounded-3">
                                        <label for="floatingPassword">QTD</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_vlu">
                                        <input input type="number" id="txt_vlu" name="txt_vlu" required class="form-control rounded-3">
                                        <label for="floatingPassword">Valor Unit</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_desc">
                                        <input input type="number" id="txt_desc" name="txt_desc" required class="form-control rounded-3">
                                        <label for="floatingPassword">Valor Desc</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_total">
                                        <input input type="number" id="txt_vl_total" name="txt_vl_total" required class="form-control rounded-3" readonly>
                                        <label for="floatingPassword">Valor Total</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3" id="status">
                                    <div>
                                        <input type="checkbox" id="chk_status" name="chk_status" checked>
                                        <label for="chk_status">Ativo</label>
                                    </div>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" id="btn_concluir" name="btn_concluir">Produtos</button>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" id="btn_concluir" name="btn_concluir">Serviços</button>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" id="btn_concluir" name="btn_concluir">Adicionar</button>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Item</th>
                                            <th>qtd</th>
                                            <th>valor unit</th>
                                        </tr>
                                        <tr>
                                            <td>Joao</td>
                                            <td>Pedro</td>
                                        </tr>
                                        <tr>
                                            <td>teste</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit"
                                    id="btn_concluir" name="btn_concluir">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>
    </main>
    <!-- Importando jquery -->
    <script src="vendor\js\jquery.js"></script>
    <script src="assets\js\venda.js"></script>
</body>

</html>