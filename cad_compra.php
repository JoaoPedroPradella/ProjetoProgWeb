<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>COMPRAS</title>
    <link rel="stylesheet" href="assets\css\menu.css">
</head>

<body>
    <main id="main_compra">
        <h1>Compras</h1>
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
                    <li class="nav-item"><button class="nav-link px-2 text-body-secondary" id="btn_detalhes" name="btn_detalhes">Detalhes</button></li>
                    <li class="nav-item"><button onclick class="nav-link px-2 text-body-secondary" id="btn_canc" name="btn_canc">Editar</button></li>
                </ul>
                <ul class="nav justify-content-center">
                    <li class="nav-item"><button id="btn_novo" id="btn_novo">NOVO</button></li>
                </ul>
            </footer>
        </div>

        <dialog id="modal_compra">
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
                                    <label for="floatingInput">Cliente</label>
                                </div>
                                <div id="transporte">
                                    <div class="form-floating mb-3" id="dv_veiculo">
                                        <select name="slc_veiculo" class="form-control rounded-3" id="slc_veiculo">
                                            <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                        </select>
                                        <label for="floatingInput">Veículos</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" id="txt_frete" name="txt_frete" required class="form-control rounded-3">
                                        <label for="floatingInput">Frete</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3" id="dv_item">
                                    <select name="slc_item" class="form-control rounded-3" id="slc_item">
                                        <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                    </select>
                                    <label for="floatingInput">Item</label>
                                </div>

                                <div id="vl_qtd">
                                    <div class="form-floating mb-3" id="dv_vlu">
                                        <input type="number" id="txt_qtd" name="txt_qtd" required class="form-control rounded-3">
                                        <label for="floatingInput">QTD</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_vlu">
                                        <input type="number" id="txt_vlu" name="txt_vlu" required class="form-control rounded-3">
                                        <label for="floatingInput">Valor</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_desc">
                                        <input type="number" id="txt_desc" name="txt_desc" required class="form-control rounded-3">
                                        <label for="floatingInput">Valor Desc</label>
                                    </div>
                                    <div class="form-floating mb-3" id="dv_total">
                                        <input type="number" id="txt_vl_total" name="txt_vl_total" required class="form-control rounded-3" readonly>
                                        <label for="floatingInput">Valor Total</label>
                                    </div>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="button" id="btn_adic" name="btn_adic">Adicionar</button>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>codigo</th>
                                            <th>descricao</th>
                                            <th>qtd</th>
                                            <th>valor</th>
                                            <th>desconto</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaItens">
                                        <!-- Lista os itens dinâmicamente -->
                                    </tbody>
                                </table>
                                <div class="form-floating mb-3" id="divTotal">
                                    Total: <label for="total" id="total"></label>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="button" id="btn_pag" name="btn_pag">Pagamento</button>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="btn_concluir" name="btn_concluir">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>

        <!-- Modal de Pagamento -->
        <dialog id="modal_pagamento">
            <div class="modal position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
                <div>
                    <div>
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <h1 class="fw-bold mb-0 fs-2" id="txt_titulo"></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="btn_fechar_pag"></button>
                        </div>

                        <div class="modal-body p-5 pt-0">
                            <form class="" id="form">
                                <div class="form-floating mb-3" id="dv_pagamento">
                                    <select name="slc_pagamento" class="form-control rounded-3" id="slc_pagamento">
                                        <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                    </select>
                                    <label for="floatingInput" id="lbl_pag">Pagamento</label>
                                </div>
                                <div class="form-floating mb-3" id="dv_pag">
                                    <input type="number" id="txt_vpag" name="txt_vpag" required class="form-control rounded-3">
                                    <label for="floatingInput">Valor</label>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="button" id="btn_adic_pag" name="btn_adic_pag">Adicionar</button>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Pagamento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaPagamentos">
                                        <!-- Lista os itens dinâmicamente -->
                                    </tbody>
                                </table>
                                <div class="form-floating mb-3" id="divRest">
                                    Restante: <label for="restante" id="restante"></label>
                                </div>
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" id="btn_cad_pag" name="btn_cad_pag">Concluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>


    </main>
    <!-- Importando jquery -->
    <script src="vendor\js\jquery.js"></script>
    <script src="assets\js\compra.js"></script>
</body>

</html>