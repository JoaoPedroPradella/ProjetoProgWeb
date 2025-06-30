if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}

$('#chk_situacao').click(function () {
    listarServicos($('#chk_situacao').prop("checked"));
});

function listarServicos(situacao) {
    if ($('#conteudo').data('loaded') === 'servico') return;

    let tipo = 'listagem';

    if (situacao === true) {
        situacao = '0'; // Marcado para listar apenas os inativos, passa 0 
    } else {
        situacao = '1'; // Desmarcado para listar apenas os inativos, passa 0
    }

    $.ajax({
        url: 'src/Application/selecionar_servico.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_servico" id="opt_servico" value="' + result[i].cd_servico + '" checked> <span>' + result[i].ds_servico + ' <small class="d-block text-body-secondary">' + result[i].cd_servico + '</small></span> </label></div>');
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
    $('#txt_id').val('NOVO');
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
});

function alterarCadastro() {
    modal.showModal();
    $('#status').show();
    $status = $('#checkbox:checked').val();

    $.ajax({
        url: 'src/Application/selecionar_servico.php',
        method: 'POST',
        data: {
            'id': $('#opt_servico:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            $('#txt_id').val(result['cd_servico']);
            $('#txt_desc').val(result['ds_servico']);
            $('#txt_tipo').val(result['tp_tipo']);
            $('#txt_vlmin').val(result['vl_minimo']);
            $('#txt_vlhr').val(result['vl_hora']);

            if (result['ds_situacao'] === '0') {
                console.log('Caiu');
                $('#chk_status').prop("checked", false)
            } else {
                $('#chk_status').prop("checked", true)
            }

            listarServicos($('#chk_situacao').prop("checked"));
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
        url: 'src/Application/inserir_servico.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'desc': $('#txt_desc').val(),
            'tipo': $('#txt_tipo').val(),
            'vlmin': $('#txt_vlmin').val(),
            'vlhr': $('#txt_vlhr').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarServicos($('#chk_situacao').prop("checked"));
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
            url: 'src/Application/excluir_servico.php',
            method: 'POST',
            data: {
                'id': $('#opt_servico:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarServicos($('#chk_situacao').prop("checked"));
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});

