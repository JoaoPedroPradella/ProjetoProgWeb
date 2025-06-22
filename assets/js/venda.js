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


function listarVendas() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'venda') return;

    $.ajax({
        url: 'src/Application/selecionar_venda.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_venda" id="opt_venda" value="' + result[i].cd_venda + '" checked> <span>' + result[i].cd_venda + '  <small class="d-block text-body-secondary"><label for="">Emissão: </label> ' + result[i].dt_emissao + '</small><small class="d-block text-body-secondary"><label for="">Total (R$): </label> ' + result[i].vl_total + '</small><small class="d-block text-body-secondary"><label for="">Status: </label> ' + result[i].ds_situacao + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
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
                    'id': ult_item_selec
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
        });
    }
})

$('#btn_editar').click(function () {
    console.log('Editar');
    $('#txttitulo').html('Editando');
    $('#btn_concluir').show();
});

$('#btn_detalhes').click(function () {
    console.log('Detalhes');
    $('#txttitulo').html('Detalhes');
    $('#btn_concluir').hide();
    console.log($('#chk_status').val());
});

function alterarCadastro() {
    modal_venda.showModal();
    $('#status').show();
    $status = $('#checkbox:checked').val();
    console.log($status);

    $.ajax({
        url: 'src/Application/selecionar_venda.php',
        method: 'POST',
        data: {
            'id': $('#opt_venda:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            selecionarCliente(function () {
                selecionarVeiculo(function () {
                    selecionarVendedor(function () {
                        selecionarProduto(function () {
                            $('#txt_id').val(result['cd_venda']);
                            $('#txt_nome').val(result['ds_venda']);
                            $('#txt_email').val(result['ds_email']);
                            $('#txt_senha').val(result['ds_senha']);
                            $('#txt_cel').val(result['ds_celular']);
                            $('#txt_cpf').val(result['ds_cpf']);
                            $('#txt_nasc').val(result['ds_nascimento']);
                            $('#txt_endereco').val(result['ds_endereco']);

                            if (result['ds_situacao'] === '0') {
                                $('#chk_status').prop("checked", false)
                            } else {
                                $('#chk_status').prop("checked", true)
                            }
                        });
                    });
                });
            });
            listarVendas();
        } else {
            console.log(result.erro);
        }

    });
};

$('#btn_fechar').click(function () {
    modal_venda.close();
    modal_pagamento.close();
})


$('#btn_fechar_pag').click(function () {
    modal_pagamento.close();
})

$('#form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: 'src/Application/inserir_venda.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'nome': $('#txt_nome').val(),
            'email': $('#txt_email').val(),
            'senha': $('#txt_senha').val(),
            'cel': $('#txt_cel').val(),
            'cpf': $('#txt_cpf').val(),
            'nasc': $('#txt_nasc').val(),
            'endereco': $('#txt_endereco').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal_venda.close();
            listarVendas();
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});


$('#btn_exc').click(function () {
    if (confirm('Tem certeza que deseja excluir o cadastro?')) {
        $.ajax({
            url: 'src/Application/excluir_venda.php',
            method: 'POST',
            data: {
                'id': $('#opt_venda:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarVendas();
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
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
            'listagem': tipo
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
            'listagem': tipo
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
            'listagem': tipo
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
            'listagem': tipo
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

$(document).on('click', '#btn_adic', function () {
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
        '<tr id="item-' + itemId + '" name="registro"><td>' + $('#slc_item').val() + '</td><td id="desc" data-value=' + $('#slc_item').val() + '>' + $('#slc_item option:selected').text() + '</td><td id="qtd">' + $('#txt_qtd').val() + '</td><td id="prec">' + $('#txt_vlu').val() + '</td><td id="desc">' + $('#txt_desc').val() + '</td><td id="tipo_item">' + tipo_item + '</td><td id="total_item">' + total_item + '</td><td> <a href="#" onclick="excluirItem(' + itemId + ')" >Excluir</a> </td><tr>');

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
        let prec = linha.querySelector('#prec').textContent;
        Novototal += Number(prec);
    }

    total.innerHTML = Novototal;
}

// Parte de pagamentos
$('#btn_pag').click(function () {
    modal_pagamento.showModal();
    listarPagamentos();
    $('#txt_vpag').val($('#total').text());
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
    if (valor_pag <= 0) {
        alert('O valor pago não pode ser menor ou igual a 0!');
    }

    $('#listaPagamentos').prepend(
        '<tr id="pag-' + pagId + '" name="registro"><td>' + $('#slc_pagamento').val() + '</td><td id="desc" data-value=' + $('#slc_pagamento').val() + '>' + $('#slc_pagamento option:selected').text() + '</td><td id="vl_pag">' + valor_pag + '</td><td> <a href="#" onclick="excluirPag(' + pagId + ')" >Excluir</a> </td><tr>');

    pagId++
    restante.innerHTML = (Number($('#total').text()) - Number(valor_pag));


})

function excluirPag(id) {
    $('#item-' + id).remove();

    // Recalculando o valor total com base nos itens da lista
    let lista = document.getElementsByName('registro');
    let Novototal = 0;

    for (i = 0; i < lista.length; i++) {
        let linha = lista[i];

        // Seleciona os <td> específicos da linha atual
        let prec = linha.querySelector('#prec').textContent;
        Novototal += Number(prec);
    }

    total.innerHTML = Novototal;
}

listarVendas();