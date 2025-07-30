if (typeof modal_venda === 'undefined') {
    const modal_venda = document.getElementById('modal_venda');
    const modal_pagamento = document.getElementById('modal_pagamento');
    let selec_vec;
    let selec_cliente;
    let selec_vendedor;
    var selec_item;
    var checado;
    var itemId = 1;
    var pagId = 1;
    let total = document.querySelector('label#total');
    let restante = document.querySelector('label#restante');
}

var total_pago = 0;

$('#chk_situacao').click(function () {
    listarVendas($('#chk_situacao').prop("checked"));
});

function listarVendas(situacao) {
    if ($('#conteudo').data('loaded') === 'venda') return;

    let tipo = 'listagem';

    if (situacao === true) {
        situacao = 'Cancelada'; // Marcado para listar apenas as vendas canceladas, passa "Cancelada"
        $('#btn_canc').hide();
    } else {
        situacao = 'Concluida'; // Desmarcado para listar apenas as vendas concluidas, passa "Concluida"
        $('#btn_canc').show();
    }

    $.ajax({
        url: 'src/Application/selecionar_venda.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': situacao
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_venda" id="opt_venda" value="' + result[i].cd_venda + '" checked> <span>' + result[i].cd_venda + '  <small class="d-block text-body-secondary"><label for="">Emissão: </label> ' + result[i].dt_emissao + '</small><small class="d-block text-body-secondary"><label for="">Total (R$): </label> ' + result[i].vl_total + '</small><small class="d-block text-body-secondary"><label for="">Status: </label> ' + result[i].ds_situacao + '</small></span> </label></div>');
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
    $('#txt_titulo').html('Nova Venda');
    $('#btn_adic').show();
    $('#btn_concluir').show();
    $('#prod_serv').show();
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
    selecionarVendedor(function () {
        selec_vendedor = $('#slc_vendedor').val();
    });
    selecionarProduto(function () {
        selec_item = $('#slc_item').val();
        $.ajax({
            url: 'src/Application/selecionar_produto.php',
            method: 'POST',
            data: {
                'id': selec_item,
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                ult_item_selec = $('#slc_item').val();
                $('#txt_vlu').val(result['vl_venda']);
                $('#txt_vl_total').val(result['vl_venda'] * $('#txt_qtd').val() - $('#txt_desc').val());
            } else {
                console.log(result.erro);
            }

        });
    });
    modal_venda.showModal();
    $('#txttitulo').html('Novo');
    $('#status').hide();
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txt_frete').val('0');
    $('#txt_qtd').val('1');
    $('#txt_desc').val('0');
    $('#txt_id').val('NOVO');

})

// Verica se deve selecionar produtos ou serviços
$('#chk_tipo').click(function () {
    checado = $('#chk_tipo').prop('checked');
    if (checado == false) {
        $('#slc_item').empty();
        selecionarProduto(function () {
            $('#slc_item').val(ult_item_selec);
            $.ajax({
                url: 'src/Application/selecionar_produto.php',
                method: 'POST',
                data: {
                    'id': ult_item_selec,
                },
                dataType: 'json'
            }).done(function (result) {
                if (!result.erro) {
                    // Chamada de função para primeiro realizar o ajax do selecionarCategoria para depois setar um valor no select
                    $('#txt_vlu').val(result['vl_venda']);
                    $('#txt_qtd').val('1');
                    $('#txt_desc').val('0');
                    $('#txt_vl_total').val(result['vl_venda'] * $('#txt_qtd').val() - $('#txt_desc').val());
                } else {
                    console.log(result.erro);
                }
            });
        });
    } else {
        $('#slc_item').empty();
        selecionarServico(function () {
            selec_item = $('#slc_item').val();
            $.ajax({
                url: 'src/Application/selecionar_servico.php',
                method: 'POST',
                data: {
                    'id': selec_item,
                },
                dataType: 'json'
            }).done(function (result) {
                tipo = '';
                if (!result.erro) {
                    $('#txt_vlu').val(result['vl_minimo']);
                    $('#txt_qtd').val('1');
                    $('#txt_desc').val('0');
                    $('#txt_vl_total').val(result['vl_minimo'] * $('#txt_qtd').val() - $('#txt_desc').val());
                } else {
                    console.log(result.erro);
                }
            });
        });
    }
})

$('#btn_detalhes').click(function () {
    modal_venda.showModal();
    $('#listaItens').empty();
    $('#listaPagamentos').empty();
    $('#txt_titulo').html('Detalhes');
    $('#btn_adic').hide();
    $('#btn_concluir').hide();
    $('#prod_serv').hide();
    $('#vl_qtd').hide();
    $('#slc_pagamento').hide();
    $('#dv_pag').hide();
    $('#btn_adic_pag').hide();
    $('#btn_cad_pag').hide();
    $('#lbl_pag').hide();
    $('#divRest').hide();


    $.ajax({
        url: 'src/Application/selecionar_venda.php',
        method: 'POST',
        data: {
            'id': $('#opt_venda:checked').val(),
        },
        dataType: 'json',
    }).done(function (result) {
        if (!result.erro) {
            const venda = result[0]; // Objeto com informações gerais
            selecionarCliente(function () {
                selecionarVeiculo(function () {
                    selecionarVendedor(function () {
                        $('#slc_cliente').val(venda.cd_cliente);
                        $('#slc_veiculo').val(venda.cd_veiculo);
                        $('#slc_vendedor').val(venda.cd_vendedor);
                    });

                });
            });
            $('#txt_frete').val(venda.vl_frete);
            $('#total').text(venda.vl_total);
            $('#txt_id').val(venda.cd_venda);


            const produtos = result[1]; // Array de produtos
            produtos.forEach(produto => {
                $('#listaItens').prepend(
                    '<tr> <td>' + produto.cd_produto + '</td><td>' + produto.ds_produto + '</td><td>' + produto.qt_venda + '</td><td>' + produto.vl_uni + '</td><td>' + produto.vl_desc + '</td><td>' + 'produto' + '</td><td>' + produto.ds_nome + '</td><td>' + produto.vl_total + '</td></tr>');
            });
            const servicos = result[2]; // Array de servicos
            servicos.forEach(servico => {
                $('#listaItens').prepend(
                    '<tr> <td>' + servico.cd_servico + '</td><td>' + servico.ds_servico + '</td><td>' + servico.qt_hora + '</td><td>' + servico.vl_hora + '</td><td>' + servico.vl_desc + '</td><td>' + 'servico' + '</td><td></td><td>' + servico.vl_total + '</td></tr>');
            });
            const pagamentos = result[3]; // Array de servicos
            pagamentos.forEach(pagamento => {
                $('#listaPagamentos').prepend(
                    '<tr> <td>' + pagamento.ds_pag + '</td><td>' + pagamento.vl_pagamento + '</td></tr>');
            });

        } else {
            console.log(result.erro); // Mostra o erro retornado pelo PHP
        }
    });
});

$('#btn_fechar').click(function () {
    modal_venda.close();
    modal_pagamento.close();
})


$('#btn_fechar_pag').click(function () {
    modal_pagamento.close();
})

$('#form').submit(function (e) {
    e.preventDefault();
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
        let tipo_item = linha.querySelector('#tipo_item').textContent;
        let id_vendedor = linha.querySelector('#vendedor').getAttribute('data-value');
        let total_item = linha.querySelector('#total_item').textContent;

        // Adiciona o item ao array "itens"
        itens.push({
            desc: desc,
            idItem: idItem,
            qtd: qtd,
            prec: prec,
            desconto: desconto,
            tipo_item: tipo_item,
            id_vendedor: id_vendedor,
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

    // Verificando se a venda tem itens
    if (itens.length === 0) {
        alert('Não é possível cadastrar uma venda sem itens!');
        return;
    }

    if (pagamentos.length === 0) {
        alert('Não é possível cadastrar uma venda sem pagamentos!');
        return;
    }

    let objItens = JSON.stringify(itens);
    let objPag = JSON.stringify(pagamentos);

    $.ajax({
        url: 'src/Application/inserir_venda.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'cliente': selec_cliente,
            'veiculo': selec_vec,
            'vendedor': selec_vendedor,
            'frete': $('#txt_frete').val(),
            'total': valorTotal,
            'objItens': objItens,
            'objPag': objPag
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            console.log(result);
            modal_venda.close();
            alert(result);
            listarVendas($('#chk_situacao').prop("checked"));;
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});


$('#btn_canc').click(function () {
    if (confirm('Tem certeza que deseja cancelar?')) {
        let itens = [];
        let servicos = [];
        $.ajax({
            url: 'src/Application/selecionar_venda.php',
            method: 'POST',
            data: {
                'id': $('#opt_venda:checked').val(),
            },
            dataType: 'json',
        }).done(function (result) {
            if (!result.erro) {
                const produtos = result[1]; // Array de produtos
                produtos.forEach(produto => {
                    itens.push({
                        id: produto.cd_produto,
                        qtd: produto.qt_venda
                    });
                });
                const serv = result[2]; // Array de serviços
                serv.forEach(servico => {
                    servicos.push({
                        id: servico.cd_servico,
                    });
                });

                if (itens.length === 0 && servicos.length === 0) {
                    alert('Não é possível cancelar uma venda sem itens!');
                    return;
                }
                let objItens = JSON.stringify(itens);
                let objServ = JSON.stringify(servicos);
                $.ajax({
                    url: 'src/Application/cancelar_venda.php',
                    method: 'POST',
                    data: {
                        'id': $('#opt_venda:checked').val(),
                        'objItens': objItens,
                        'objServ': objServ
                    },
                    dataType: 'json'
                }).done(function (result) {
                    tipo = '';
                    if (!result.erro) {
                        alert(result);
                        listarVendas($('#chk_situacao').prop("checked"));;
                    } else {
                        alert('Existem erros! Verifique')
                        console.log(result.erro);
                    }
                });
            } else {
                console.log(result.erro); // Mostra o erro retornado pelo PHP
            }
        });

    }
});

function selecionarCliente(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_cliente.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': '1' // Lista apenas os ativos
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
            'situacao': '1' // Lista apenas os ativos
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
            'situacao': '1' // Lista apenas os ativos
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

function selecionarServico(callback) {
    let tipo = 'listagem';
    $.ajax({
        url: 'src/Application/selecionar_servico.php',
        method: 'POST',
        data: {
            'listagem': tipo,
            'situacao': '1' // Lista apenas os ativos
        },
        dataType: 'json'
    }).done(function (result) {
        tipo = '';
        if (!result.erro) {
            $('#slc_item').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_item').prepend(
                    '<option value="' + result[i].cd_servico + '">' + result[i].ds_servico + '</option>');
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

        if ($('#chk_tipo').prop('checked') == false) {
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
                    $('#txt_vlu').val(result['vl_venda']);
                    $('#txt_qtd').val('1');
                    $('#txt_desc').val('0');
                    $('#txt_vl_total').val(result['vl_venda'] * $('#txt_qtd').val() - $('#txt_desc').val());
                } else {
                    console.log(result.erro);
                }

            });
        } else {
            $.ajax({
                url: 'src/Application/selecionar_servico.php',
                method: 'POST',
                data: {
                    'id': selec_item
                },
                dataType: 'json'
            }).done(function (result) {
                tipo = '';
                if (!result.erro) {
                    $('#txt_vlu').val(result['vl_minimo']);
                    $('#txt_qtd').val('1');
                    $('#txt_desc').val('0');
                    $('#txt_vl_total').val(result['vl_minimo'] * $('#txt_qtd').val() - $('#txt_desc').val());
                } else {
                    console.log(result.erro);
                }
            });
        }
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

    if ($('#chk_tipo').prop('checked') == false) {
        tipo_item = 'produto';
    } else {
        tipo_item = 'servico'
    }

    // Incluindo os itens na listagem
    $('#listaItens').prepend(
        '<tr id="item-' + itemId + '" name="registro"><td>' + $('#slc_item').val() + '</td><td id="desc" data-value=' + $('#slc_item').val() + '>' + $('#slc_item option:selected').text() + '</td><td id="qtd">' + $('#txt_qtd').val() + '</td><td id="prec">' + $('#txt_vlu').val() + '</td><td id="desconto_item">' + $('#txt_desc').val() + '</td><td id="tipo_item">' + tipo_item + '</td><td id="vendedor" data-value=' + selec_vendedor + '>' + $('#slc_vendedor option:selected').text() + '</td><td id="total_item">' + total_item + '</td><td> <a href="#" onclick="excluirItem(' + itemId + ')" >Excluir</a> </td><tr>');

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
    $('#dv_parcela').hide();
    $('#tb_parcelas').hide();
    $('#dv_intervalo').hide();

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
            'listagem': tipo,
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
            tipo_pag();
        } else {
            console.log(result.erro);
        }
    });
}

$('#btn_adic_pag').click(function () {

    let valor_pag = $('#txt_vpag').val();
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
    }
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


// -------------------------  Venda a prazo ---------------------------------
function tipo_pag() {
    let tipo_pag = $('#slc_pagamento option:selected').text()

    if (tipo_pag.indexOf("Prazo") != -1 || tipo_pag.indexOf("prazo") != -1) {
        $('#dv_parcela').show();
        $('#tb_parcelas').show();
        $('#dv_intervalo').show();
        $('#listaParcelas').empty();
        $('#txt_parcela').val('1');
        $('#txt_intervalo').val('1');
        lista_parcelas(Number($('#txt_parcela').val()), Number($('#txt_intervalo').val()));

        $('#txt_parcela, #txt_intervalo, #txt_vpag').on('input', function () {
            $('#listaParcelas').empty();
            lista_parcelas(Number($('#txt_parcela').val()), Number($('#txt_intervalo').val()));
        })
    } else {
        $('#dv_parcela').hide();
        $('#tb_parcelas').hide();
        $('#dv_intervalo').hide();

    }
}

function lista_parcelas(qtd_parcelas, intervalo) {
    let dataAtual;
    let dataFutura;
    let valor;

    valor = $('#txt_vpag').val() / qtd_parcelas

    for (var i = 1; i <= qtd_parcelas; i++) {
        dataAtual = new Date(); // Cria a data de hoje
        dataAtual.setDate(dataAtual.getDate() + intervalo * i); // Adiciona 30 dias
        dataFutura = dataAtual.toISOString().split('T')[0]

        $('#listaParcelas').prepend(
            '<tr id="parc-' + i + '" name="registroParc"><td> ' + i + '</td><td><input type="number" id="txt_val_parc" name="txt_val_parc" class="txt_val_parc" value="' + valor.toFixed(2).replace('.', ',') + '" required class="form-control rounded-3"></input></td><td><input type="date" id="txt_vencimento" name="txt_vencimento" value="' + dataFutura + '" required class="form-control rounded-3"></td><tr>');
    }

    $('.txt_val_parc').on('input', function () {
        let lista = document.getElementsByName('registroParc'); 
        let totalPag = parseFloat($('#txt_vpag').val().replace(',', '.'));
        let numeros = []; // parcelas alteradas
        let somaAtual = 0;
    
        // Detecta parcelas alteradas
        for (let i = 0; i < lista.length; i++) {
            let input = lista[i].querySelector('.txt_val_parc');
            if (input) {
                let valorOriginal = totalPag / lista.length;
                let valorInput = parseFloat(input.value.replace(',', '.')) || 0;
    
                // Considera alterado se valor for diferente do original (com margem)
                if (Math.abs(valorInput - valorOriginal) > 0.01) {
                    numeros.push({ numero: i, valor: valorInput });
                }
    
                somaAtual += valorInput;
            }
        }
    
        if (numeros.length < lista.length) {
            // Ainda há parcelas não alteradas → recalcula elas
            let totalAlterado = numeros.reduce((soma, item) => soma + item.valor, 0);
            let restante = totalPag - totalAlterado;
            let faltam = lista.length - numeros.length;
            let novoValor = (restante / faltam).toFixed(2);
    
            for (let i = 0; i < lista.length; i++) {
                if (!numeros.some(obj => obj.numero === i)) {
                    let input = lista[i].querySelector('.txt_val_parc');
                    if (input) {
                        input.value = novoValor.replace('.', ',');
                    }
                }
            }
    
        } else {
            // Todas foram alteradas → verifica se soma bate
            let diferenca = totalPag - somaAtual;
    
            if (Math.abs(diferenca) > 0.01) {
                // Ajusta apenas a primeira parcela
                let primeira = lista[0].querySelector('.txt_val_parc');
                if (primeira) {
                    let atual = parseFloat(primeira.value.replace(',', '.')) || 0;
                    let novo = atual + diferenca;
    
                    if (novo <= 0) novo = 0.01;
    
                    primeira.value = novo.toFixed(2).replace('.', ',');
                }
            }
        }
    });
    
}



