$('#btn_pedro').click(function () {
    let nome = prompt('Informe o nome:');
    let token = prompt('Informe o token:');
    // window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/pedro_api/menu_pedro.php';

    window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/pedro_api/menu_pedro.php?nome=' + nome + '&token=' + token;

});

$('#cliente').click(function (e) {
    e.preventDefault();
    let nome = $(this).data('nome');
    let token = $(this).data('token');

    // Acessa o WebService para coletar os dados
    $.ajax({
        url: 'http://192.168.0.202/erp/json/buscaclientes.php?ds_nome=' + nome + '&ds_token=' + token + '',
        method: 'POST',
        dataType: 'json'
    }).done(function (result) {
        console.log('✅ API retornou:', result);

        // Envia os dados para uma pagina php onde vai ser feito o cadastro
        $.ajax({
            url: 'cad_clientes.php',
            method: 'POST',
            data: { 
                clientes: JSON.stringify(result) 
            },
            dataType: 'json'
        }).done(function (result) {
            console.log('✅ API retornou:', result);
            if (!resposta.erro) {
                alert('✅ Clientes cadastrados com sucesso!');
            } else {
                console.log(result.erro);
            }
    
        });

    });


});

$('#produto').click(function (e) {
    e.preventDefault();
    let nome = $(this).data('nome');
    let token = $(this).data('token');

    // Acessa o WebService para coletar os dados
    $.ajax({
        url: 'http://192.168.0.202/erp/json/buscaprodutos.php?ds_nome=' + nome + '&ds_token=' + token + '',
        method: 'POST',
        dataType: 'json'
    }).done(function (result) {
        console.log('✅ API retornou:', result);

        // Envia os dados para uma pagina php onde vai ser feito o cadastro
        $.ajax({
            url: 'cad_produto.php',
            method: 'POST',
            data: { 
                produtos: JSON.stringify(result) 
            },
            dataType: 'json'
        }).done(function (result) {
            console.log('✅ API retornou:', result);
            if (!resposta.erro) {
                alert('✅ Produtos cadastrados com sucesso!');
            } else {
                console.log(result.erro);
            }
    
        });

    });


});

$('#venda').click(function (e) {
    e.preventDefault();
    let nome = $(this).data('nome');
    let token = $(this).data('token');

    // Acessa o WebService para coletar os dados
    $.ajax({
        url: 'http://192.168.0.202/erp/json/buscavendas.php?ds_nome=' + nome + '&ds_token=' + token + '',
        method: 'POST',
        dataType: 'json'
    }).done(function (result) {
        console.log('✅ API retornou:', result);

        // Envia os dados para uma pagina php onde vai ser feito o cadastro
        $.ajax({
            url: 'cad_venda.php',
            method: 'POST',
            data: { 
                vendas: JSON.stringify(result) 
            },
            dataType: 'json'
        }).done(function (result) {
            console.log('✅ API retornou:', result);
            if (!resposta.erro) {
                alert('✅ Vendas cadastradas com sucesso!');
            } else {
                console.log(result.erro);
            }
    
        });

    });


});

$('#usuario').click(function (e) {
    e.preventDefault();
    let nome = $(this).data('nome');
    let token = $(this).data('token');

    // Acessa o WebService para coletar os dados
    $.ajax({
        url: 'http://192.168.0.202/erp/json/buscausuarios.php?ds_nome=' + nome + '&ds_token=' + token + '',
        method: 'POST',
        dataType: 'json'
    }).done(function (result) {
        console.log('✅ API retornou:', result);

        // Envia os dados para uma pagina php onde vai ser feito o cadastro
        $.ajax({
            url: 'cad_usuarios.php',
            method: 'POST',
            data: { 
                usuarios: JSON.stringify(result) 
            },
            dataType: 'json'
        }).done(function (result) {
            console.log('✅ API retornou:', result);
            if (!resposta.erro) {
                alert('✅ Usuarios cadastradas com sucesso!');
            } else {
                console.log(result.erro);
            }
    
        });

    });


});

$('#veiculo').click(function (e) {
    e.preventDefault();
    let nome = $(this).data('nome');
    let token = $(this).data('token');

    // Acessa o WebService para coletar os dados
    $.ajax({
        url: 'http://192.168.0.202/erp/json/buscaveiculos.php?ds_nome=' + nome + '&ds_token=' + token + '',
        method: 'POST',
        dataType: 'json'
    }).done(function (result) {
        console.log('✅ API retornou:', result);

        // Envia os dados para uma pagina php onde vai ser feito o cadastro
        $.ajax({
            url: 'cad_veiculos.php',
            method: 'POST',
            data: { 
                veiculos: JSON.stringify(result) 
            },
            dataType: 'json'
        }).done(function (result) {
            console.log('✅ API retornou:', result);
            if (!resposta.erro) {
                alert('✅ Veículos cadastradas com sucesso!');
            } else {
                console.log(result.erro);
            }
    
        });

    });


});