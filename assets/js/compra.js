if (typeof modal_compra === 'undefined') {
    const modal_compra = document.getElementById('modal_compra');
    const modal_pagamento = document.getElementById('modal_pagamento');
    let selec_vec;
    let selec_cliente;
    var selec_item;
    var checado;
    var itemId = 1;
    var pagId = 1;
    let total = document.querySelector('label#total');
    let restante = document.querySelector('label#restante');
}

var total_pago = 0;

function listarCompras() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'compra') return;

    $.ajax({
        url: 'src/Application/selecionar_compra.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_compra" id="opt_compra" value="' + result[i].cd_compra + '" checked> <span>' + result[i].cd_compra + '  <small class="d-block text-body-secondary"><label for="">Emissão: </label> ' + result[i].dt_emissao + '</small><small class="d-block text-body-secondary"><label for="">Data Entrada: </label> ' + result[i].dt_entrada + '</small><small class="d-block text-body-secondary"><label for="">Total (R$): </label> ' + result[i].vl_total + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
    total_pago = 0;
    $('#listaItens').empty();
    $('#listaPagamentos').empty();
    $('#txt_titulo').html('Nova Compra');
    $('#btn_adic').show();
    $('#btn_concluir').show();
    $('#dv_item').show();
    $('#vl_qtd').show();
    $('#slc_pagamento').show();
    $('#dv_pag').show();
    $('#btn_adic_pag').show();
    $('#btn_cad_pag').show();
    $('#lbl_pag').show();
    $('#divRest').show();
    $('#total').text(0);

    selecionarCliente(function () {
        selec_cliente = $('#slc_cliente').val();
    });;
    selecionarVeiculo(function () {
        selec_vec = $('#slc_veiculo').val();
    });
    selecionarProduto(function () {
        selec_item = $('#slc_item').val();
        console.log($('#slc_item').text());
        $.ajax({
            url: 'src/Application/selecionar_produto.php',
            method: 'POST',
            data: {
                'id': selec_item
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                // Chamada de função para primeiro realizar o ajax do selecionarCategoria para depois setar um valor no select
                ult_item_selec = $('#slc_item').val();
                $('#txt_vlu').val(result['vl_compra']);
                $('#txt_vl_total').val(result['vl_compra'] * $('#txt_qtd').val() - $('#txt_desc').val());
            } else {
                console.log(result.erro);
            }

        });
    });
    modal_compra.showModal();
    $('#txttitulo').html('Novo');
    $('#status').hide();
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txt_frete').val('0');
    $('#txt_qtd').val('1');
    $('#txt_desc').val('0');
    $('#txt_id').val('NOVO');

})

$('#btn_editar').click(function () {
    console.log('Editar');
    $('#txttitulo').html('Editando');
    $('#btn_concluir').show();
});

$('#btn_detalhes').click(function () {
    modal_compra.showModal();
    $('#listaItens').empty();
    $('#listaPagamentos').empty();
    console.log('Detalhes');
    $('#txt_titulo').html('Detalhes');
    $('#btn_adic').hide();
    $('#btn_concluir').hide();
    $('#dv_item').hide();
    $('#vl_qtd').hide();
    $('#slc_pagamento').hide();
    $('#dv_pag').hide();
    $('#btn_adic_pag').hide();
    $('#btn_cad_pag').hide();
    $('#lbl_pag').hide();
    $('#divRest').hide();

    
    $.ajax({
        url: 'src/Application/selecionar_compra.php',
        method: 'POST',
        data: {
            'id': $('#opt_compra:checked').val(),
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            const compra = result[0]; // Objeto com informações gerais
            console.log(compra.cd_cliente);
            console.log(compra.ds_nome);
            selecionarCliente(function () {
                selecionarVeiculo(function () {
                        $('#slc_cliente').val(compra.cd_cliente);
                        $('#slc_veiculo').val(compra.cd_veiculo);
                });
            });
            $('#txt_frete').val(compra.vl_frete);
            $('#total').text(compra.vl_total);
            $('#txt_id').val(compra.cd_compra);
            
            const produtos = result[1]; // Array de produtos
            produtos.forEach(produto => {
                $('#listaItens').prepend(
                    '<tr> <td>' + produto.cd_produto + '</td><td>' + produto.ds_produto + '</td><td>' + produto.qt_compra + '</td><td>' + produto.vl_uni + '</td><td>' + produto.vl_desc + '</td><td>' + 'produto' + '</td><td>' + produto.vl_total + '</td></tr>');
            });
            const pagamentos = result[2]; // Array de servicos
            pagamentos.forEach(pagamento => {
                $('#listaPagamentos').prepend(
                    '<tr> <td>' + pagamento.ds_pag + '</td><td>' + pagamento.vl_pagamento + '</td></tr>');
            });
            console.log(result);
        } else {
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
});

$('#btn_fechar').click(function () {
    modal_compra.close();
    modal_pagamento.close();
})


$('#btn_fechar_pag').click(function () {
    modal_pagamento.close();
})

$('#form').submit(function (e) {
    e.preventDefault();
    console.log(restante.innerHTML);
    if (!Number(restante.innerHTML) == 0 || restante.innerHTML === '') {
        alert('Informe o pagamento completo!');
        return;
    }

    let lista = document.getElementsByName('registro');
    let listaPagamentos = document.getElementsByName('registroPag');
    let valorTotal = $('#total').text();
    let itens = [];
    let pagamentos = [];

    // Capturar os itens
    for (i = 0; i < lista.length; i++) {
        let linha = lista[i];

        // Seleciona os <td> específicos da linha atual
        let desc = linha.querySelector('#desc').textContent;
        let idItem = linha.querySelector('#desc').getAttribute('data-value');
        let qtd = linha.querySelector('#qtd').textContent;
        let prec = linha.querySelector('#prec').textContent;
        let desconto = linha.querySelector('#desconto_item').textContent;
        let total_item = linha.querySelector('#total_item').textContent;

        // Adiciona o item ao array "itens"
        itens.push({
            desc: desc,
            idItem: idItem,
            qtd: qtd,
            prec: prec,
            desconto: desconto,
            total_item: total_item
        });
    }

    // Capturar os pagamentos
    for (i = 0; i < listaPagamentos.length; i++) {
        let linha = listaPagamentos[i];

        // Seleciona os <td> específicos da linha atual
        let descPag = linha.querySelector('#desc_pag').textContent;
        let idPag = linha.querySelector('#desc_pag').getAttribute('data-value');
        let val_pago = linha.querySelector('#vl_pag').textContent;

        // Adiciona o item ao array "itens"
        pagamentos.push({
            descPag: descPag,
            idPag: idPag,
            val_pago: val_pago
        });

    }

    // Verificando se a compra tem itens
    if (itens.length === 0) {
        alert('Não é possível cadastrar uma compra sem itens!');
        return;
    }

    if (pagamentos.length === 0) {
        alert('Não é possível cadastrar uma compra sem pagamentos!');
        return;
    }

    let objItens = JSON.stringify(itens);
    let objPag = JSON.stringify(pagamentos);

    $.ajax({
        url: 'src/Application/inserir_compra.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'cliente': selec_cliente,
            'veiculo': selec_vec,
            'frete': $('#txt_frete').val(),
            'total': valorTotal,
            'objItens': objItens,
            'objPag': objPag
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            console.log(result);
            modal_compra.close();
            alert(result);
            listarCompras();
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});

function selecionarCliente(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_cliente.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': '1'
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#slc_cliente').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_cliente').prepend(
                    '<option value="' + result[i].cd_cliente + '">' + result[i].ds_nome + '</option>');
            }
            if (typeof callback === "function") {
                callback();
            }
        } else {
            console.log(result.erro);
        }
    });
}

function selecionarVeiculo(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_veiculo.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': '1'
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#slc_veiculo').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_veiculo').prepend(
                    '<option value="' + result[i].cd_veiculo + '">' + result[i].ds_tipo + '</option>');
            }
            if (typeof callback === "function") {
                callback();
            }
        } else {
            console.log(result.erro);
        }
    });
}

function selecionarVendedor(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_vendedor.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#slc_vendedor').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_vendedor').prepend(
                    '<option value="' + result[i].cd_vendedor + '">' + result[i].ds_nome + '</option>');
            }
            if (typeof callback === "function") {
                callback();
            }
        } else {
            console.log(result.erro);
        }
    });
}

function selecionarProduto(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_produto.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': '1'
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {

            $('#slc_item').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_item').prepend(
                    '<option value="' + result[i].cd_produto + '">' + result[i].ds_produto + '</option>');
            }
            if (typeof callback === "function") {
                callback();
            }
        } else {
            console.log(result.erro);
        }
    });
}

$(document).ready(function () {
    $('#slc_cliente').change(function () {
        selec_cliente = $(this).val();
    });
});

$(document).ready(function () {
    $('#slc_veiculo').change(function () {
        selec_vec = $(this).val();
    });
});

$(document).ready(function () {
    $('#slc_vendedor').change(function () {
        selec_vendedor = $(this).val();
    });
});

$(document).ready(function () {
    $('#slc_item').change(function () {
        selec_item = $(this).val();
            $.ajax({
                url: 'src/Application/selecionar_produto.php',
                method: 'POST',
                data: {
                    'id': selec_item
                },
                dataType: 'json'
            }).done(function (result) {
                if (!result.erro) {
                    // Captura o value do item selecionado, para selecionar o mesmo item quando o checkbox do serviço for desmarcado
                    ult_item_selec = $('#slc_item').val();
                    // Chamada de função para primeiro realizar o ajax do selecionarCategoria para depois setar um valor no select
                    $('#txt_vlu').val(result['vl_compra']);
                    $('#txt_qtd').val('1');
                    $('#txt_desc').val('0');
                    $('#txt_vl_total').val(result['vl_compra'] * $('#txt_qtd').val() - $('#txt_desc').val());
                } else {
                    console.log(result.erro);
                }

            });
    });
});

$('#txt_vlu, #txt_qtd, #txt_desc').on('input', function () {
    let qtd = parseFloat($('#txt_qtd').val()) || 0;
    let preco = parseFloat($('#txt_vlu').val()) || 0;
    let desc = parseFloat($('#txt_desc').val()) || 0;
    let total_item = qtd * preco - desc;
    $('#txt_vl_total').val(total_item.toFixed(2));
})

$('#btn_adic').click(function () {
    let total_item = $('#txt_vl_total').val();

    if (total_item <= 0) {
        alert('O valor total não pode ser menor ou igual a 0!')
    }
    let tipo_item;

    // Incluindo os itens na listagem
    $('#listaItens').prepend(
        '<tr id="item-' + itemId + '" name="registro"><td>' + $('#slc_item').val() + '</td><td id="desc" data-value=' + $('#slc_item').val() + '>' + $('#slc_item option:selected').text() + '</td><td id="qtd">' + $('#txt_qtd').val() + '</td><td id="prec">' + $('#txt_vlu').val() + '</td><td id="desconto_item">' + $('#txt_desc').val() + '</td><td id="total_item">' + total_item + '</td><td> <a href="#" onclick="excluirItem(' + itemId + ')" >Excluir</a> </td><tr>');

    itemId++
    total.innerHTML = Number(total.innerHTML) + Number(total_item);
})



function excluirItem(id) {
    $('#item-' + id).remove();

    // Recalculando o valor total com base nos itens da lista
    let lista = document.getElementsByName('registro');
    let Novototal = 0;

    for (i = 0; i < lista.length; i++) {
        let linha = lista[i];

        // Seleciona os <td> específicos da linha atual
        let prec = linha.querySelector('#total_item').textContent;
        Novototal += Number(prec);
    }

    total.innerHTML = Novototal;
}


// -------------------------  Parte de pagamentos ---------------------------------

$('#btn_pag').click(function () {
    modal_pagamento.showModal();
    listarPagamentos();
    $('#txt_vpag').val($('#total').text()) - Number(total_pago);
    if (restante.innerHTML == 0 && total_pago == 0) {
        restante.innerHTML = $('#total').text();
    } else {
        restante.innerHTML = $('#total').text() - total_pago;
        $('#txt_vpag').val($('#total').text() - total_pago);
    }

})

function listarPagamentos() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'pagamento') return;

    $.ajax({
        url: 'src/Application/selecionar_pagamento.php',
        method: 'POST',
        data: {
            'listagem': tipo
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#slc_pagamento').empty();

            for (var i = 0; i < result.length; i++) {
                $('#slc_pagamento').prepend(
                    '<option value="' + result[i].cd_pag + '">' + result[i].ds_pag + '</option>');
            }
        } else {
            console.log(result.erro);
        }
    });
}

$('#btn_adic_pag').click(function () {

    let valor_pag = $('#txt_vpag').val();
    console.log(restante.innerHTML);
    console.log(valor_pag);
    if (Number(valor_pag) <= 0) {
        alert('O valor pago não pode ser menor ou igual a 0!');
    } else if (Number(valor_pag) > Number(restante.innerHTML)) {
        alert('O valor de pagamentos não pode ser maior que o total da nota!')
    } else {

        $('#listaPagamentos').prepend(
            '<tr id="pag-' + pagId + '" name="registroPag"><td id="desc_pag" data-value=' + $('#slc_pagamento').val() + '>' + $('#slc_pagamento option:selected').text() + '</td><td id="vl_pag">' + valor_pag + '</td><td> <a href="#" onclick="excluirPag(' + pagId + ')" >Excluir</a> </td><tr>');

        total_pago = total_pago + Number(valor_pag);

        pagId++
        restante.innerHTML = Number(restante.innerHTML) - (Number(valor_pag));
    }

})

function excluirPag(id) {
    $('#pag-' + id).remove();
    // Recalculando o valor total com base nos itens da lista
    let listaPag = document.getElementsByName('registroPag');
    let Novototal = 0;

    for (i = 0; i < listaPag.length; i++) {
        let linha = listaPag[i];

        // Seleciona os < td > específicos da linha atual
        let pag = linha.querySelector('#vl_pag').textContent;
        Novototal += Number(pag);
        console.log(Novototal);
    }
    console.log(Novototal);
    restante.innerHTML = $('#total').text() - Novototal;
    total_pago = Novototal;
}

$('#btn_cad_pag').click(function (e) {
    e.preventDefault();
    if (!Number(restante.innerHTML) == 0) {
        alert('Informe o pagamento completo!');
        return;
    }
    modal_pagamento.close();
})
listarCompras();