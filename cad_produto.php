<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>List groups · Bootstrap v5.3</title>
    <link rel="stylesheet" href="assets\css\menu.css">
</head>

<body>
    <main id="main_produto">
        <h1>Produtos</h1>
        <div>
            <input type="checkbox" id="chk_situacao" name="chk_situacao"> Inativos
        </div>
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

        <dialog id="modal">
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
                                <div class="form-floating mb-3">
                                    <input type="text" id="txt_desc" name="txt_desc" required
                                        class="form-control rounded-3">
                                    <label for="floatingPassword">Descrição</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" id="txt_und" name="txt_und" required
                                        class="form-control rounded-3">
                                    <label for="floatingPassword">Und</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input input type="number" id="txt_custo" name="txt_custo" required class="form-control rounded-3">
                                    <label for="floatingPassword">Custo</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" id="txt_qtd" name="txt_qtd" required
                                        class="form-control rounded-3">
                                    <label for="floatingPassword">Quantidade</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" id="txt_preco" name="txt_preco" required class="form-control rounded-3">
                                    <label for="floatingPassword">Preço</label>
                                </div>
                                <div class="form-floating mb-3" id="dv_categoria">
                                    <select name="slc_categoria" class="form-control rounded-3" id="slc_categoria">
                                        <!-- Serão adicionadas dinamicamente as categorias aqui -->
                                    </select>
                                    <label for="floatingPassword">Categoria</label>
                                </div>
                                <div class="form-floating mb-3" id="status">
                                    <div>
                                        <input type="checkbox" id="chk_status" name="chk_status" checked>
                                        <label for="chk_status">Ativo</label>
                                    </div>
                                </div>
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
    <script src="assets\js\produto.js"></script>
</body>

</html>