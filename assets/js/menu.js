// Exibe a lista de clientes
let paginaAtual = '';

$("#carregarCliente").click(function () {
    if (paginaAtual === 'cliente') return; // já carregado, não faz nada

    $("#conteudo").load("cad_cliente.php", function () {
        paginaAtual = 'cliente'; // marca que já carregou cliente
        listarClientes(); // só chama após o carregamento
    });
});