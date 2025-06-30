if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}

$('#chk_situacao').click(function () {
    listarClientes($('#chk_situacao').prop("checked"));
});


function listarClientes(situacao) {
    if ($('#conteudo').data('loaded') === 'cliente') return;

    let tipo = 'listagem';

    if (situacao === true) {
        situacao = '0'; // Marcado para listar apenas os inativos, passa 0 
    } else {
        situacao = '1'; // Desmarcado para listar apenas os inativos, passa 0
    }

    $.ajax({
        url: 'src/Application/selecionar_cliente.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_cliente" id="opt_cliente" value="' + result[i].cd_cliente + '" checked> <span>' + result[i].ds_nome + ' <small class="d-block text-body-secondary">' + result[i].cd_cliente + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
    modal.showModal();
    $('#txttitulo').html('Novo');
    $('#status').hide();
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txtid').val('NOVO');
})

$('#btn_editar').click(function () {
    $('#txttitulo').html('Editando');
    $('#btn_concluir').show();
});

$('#btn_detalhes').click(function () {
    $('#txttitulo').html('Detalhes');
    $('#btn_concluir').hide();
});

function alterarCadastro() {
    modal.showModal();
    $('#status').show();
    $status = $('#checkbox:checked').val();

    $.ajax({
        url: 'src/Application/selecionar_cliente.php',
        method: 'POST',
        data: {
            'id': $('#opt_cliente:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            $('#txtid').val(result['cd_cliente']);
            $('#txtnome').val(result['ds_nome']);
            $('#txtcpf_cnpj').val(result['ds_cpf_cnpj']);
            $('#txttel').val(result['ds_tel']);
            $('#txtcep').val(result['ds_cep']);
            $('#txtuf').val(result['ds_uf']);
            $('#txtmunic').val(result['ds_municipio']);
            $('#txtlog').val(result['ds_logradouro']);

            if (result['tp_tipo'] === '0') {
                $('#chk_status').prop("checked", false)
            } else {
                $('#chk_status').prop("checked", true)
            }

            listarClientes($('#chk_situacao').prop("checked"));
        } else {
            console.log(result.erro);
        }

    });
};

$('#btn_fechar').click(function () {
    modal.close();
})

$('#form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: 'src/Application/inserir_cliente.php',
        method: 'POST',
        data: {
            'id': $('#txtid').val(),
            'nome': $('#txtnome').val(),
            'cpf_cnpj': $('#txtcpf_cnpj').val(),
            'telefone': $('#txttel').val(),
            'cep': $('#txtcep').val(),
            'uf': $('#txtuf').val(),
            'munic': $('#txtmunic').val(),
            'lograd': $('#txtlog').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarClientes($('#chk_situacao').prop("checked"));
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});

/*$('#bnt_consultaCEP').click(function(){
    $.ajax({
        url: 'src/Application/consulta_cep.php',
        method: 'POST',
        data: {
            'cep': $('#txtcep').val(),
        },
        dataType: 'json'
    }).done(function(result){
        alert(result);
    })
})*/

$('#btn_exc').click(function () {
    if (confirm('Tem certeza que deseja excluir o cadastro?')) {
        $.ajax({
            url: 'src/Application/excluir_cliente.php',
            method: 'POST',
            data: {
                'id': $('#opt_cliente:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarClientes($('#chk_situacao').prop("checked"));
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});
