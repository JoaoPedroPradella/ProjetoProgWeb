<?php
declare(strict_types=1);
use App\Models\Usuario;
session_set_cookie_params(['httponly' => true]);
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="assets\css\menu.css">
    <title>MENU</title>
</head>

<body>
    <main class="d-flex flex-nowrap">
        <h1 class="visually-hidden">MENU</h1>

        <div class="flex-shrink-0 p-3" style="width: 280px;"><svg class="bi pe-none me-2" width="30" height="24"
                aria-hidden="true">
            </svg> <span class="fs-5 fw-semibold">MENU</span> </a>
            <ul class="list-unstyled ps-0">
                <li class="mb-1"> <button
                        class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        Cadastros
                    </button>
                    <div class="collapse" id="home-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="page_num">
                            <li><a href="#" id="carregarCliente"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Clientes</a>
                            </li>
                            <li><a href="#" id="carregarProduto"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Produtos</a>
                            </li>
                            <li><a href="#" id="carregarCategoria"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Categorias</a>
                            </li>
                            <li><a href="#" id="carregarServico"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Serviços</a>
                            </li>
                            <li><a href="#" id="carregarVeiculos"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Veículos</a>
                            </li>
                            <li><a href="#" id="carregarVendedor"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Vendedores</a>
                            </li>
                            <li><a href="#" id="carregarPagamento"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Pagamentos</a>
                            </li>
                            <li><a href="#" id="carregarUsuarios"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Usuários</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1"> <button
                        class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                        Movimentações
                    </button>
                    <div class="collapse" id="dashboard-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" id="carregarVendas"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Vendas</a>
                            </li>
                            <li><a href="#" id="carregarCompras"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Compras</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1"> <button
                        class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                        Financeiro
                    </button>
                    <div class="collapse" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Livro
                                    Caixa</a></li>
                            <li><a href="#"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Receber</a>
                            </li>
                            <li><a href="#"
                                    class="link-body-emphasis d-inline-flex text-decoration-none rounded">Pagar</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="border-top my-3"></li>
                <li class="mb-1"> <button
                        class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false" onclick="logout()">
                        Sair
                    </button>
                </li>
            </ul>
            
        </div>
        <div id="conteudo">
            <h1>Bem-vindo <?php echo $_SESSION['nome'] ?> </h1>
            <!-- Vai chamar o conteúdo do cadastro do cliente (Ajax) -->
        </div>
    </main>
    <script src="vendor\js\jquery.js"></script>
    <script src="assets\js\usuario.js"></script>
    <script src="assets\js\menu.js"></script>
    
</body>

</html>
