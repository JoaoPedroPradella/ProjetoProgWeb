// Exibe a lista de clientes
let paginaAtual = '';

$("#carregarCliente").click(function () {
    if (paginaAtual === 'cliente') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_cliente.php", function () {
        paginaAtual = 'cliente'; // marca que já carregou cliente
        listarClientes(); // só chama após o carregamento
    });
});

$("#carregarCategoria").click(function () {
    if (paginaAtual === 'categoria') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_categoria.php", function () {
        paginaAtual = 'categoria'; // marca que já carregou cliente
        listarCategorias(); // só chama após o carregamento
    });
});

$("#carregarProduto").click(function () {
    if (paginaAtual === 'produto') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_produto.php", function () {
        paginaAtual = 'produto'; // marca que já carregou cliente
        listarProdutos(); // só chama após o carregamento
    });
});

$("#carregarServico").click(function () {
    if (paginaAtual === 'servico') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_servico.php", function () {
        paginaAtual = 'servico'; // marca que já carregou cliente
        listarServicos(); // só chama após o carregamento
    });
});

$("#carregarVeiculos").click(function () {
    if (paginaAtual === 'veiculo') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_veiculo.php", function () {
        paginaAtual = 'veiculo'; // marca que já carregou cliente
        listarVeiculos(); // só chama após o carregamento
    });
});

$("#carregarVendedor").click(function () {
    if (paginaAtual === 'vendedor') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_vendedor.php", function () {
        paginaAtual = 'vendedor'; // marca que já carregou cliente
        listarVendedores(); // só chama após o carregamento
    });
});

$("#carregarPagamento").click(function () {
    if (paginaAtual === 'pagamento') return; // já carregado, não faz nada
  
    $("#conteudo").load("cad_pagamento.php", function () {
        paginaAtual = 'pagamento'; // marca que já carregou cliente
        listarPagamentos(); // só chama após o carregamento
    });
});