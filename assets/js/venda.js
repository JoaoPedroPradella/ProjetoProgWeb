if (typeof modal_venda === 'undefined') {
    const modal_venda = document.getElementById('modal_venda');
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
    selecionarCliente();
    selecionarVeiculo();
    selecionarVendedor();
    selecionarProduto();
    
    modal_venda.showModal();
    $('#txttitulo').html('Novo');
    $('#status').hide();
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txt_id').val('NOVO');
})

// Verica se deve selecionar produtos ou serviços
$('#chk_tipo').click(function () {
    let checado = $('#chk_tipo').prop('checked');
    if (checado == false) {
        $('#slc_item').empty();
        selecionarProduto();
    } else {
        $('#slc_item').empty();
        selecionarServico();
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
                                console.log('Caiu');
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

$(document).on('click', '#btn_adic', function () {
    console.log($('#txt_vlu').val())
})

listarVendas();