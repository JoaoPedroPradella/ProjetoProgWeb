if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}


function listarVeiculos() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'veiculo') return;

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
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_veiculo" id="opt_veiculo" value="' + result[i].cd_veiculo + '" checked> <span>' + result[i].ds_tipo + ' <small class="d-block text-body-secondary">' + result[i].cd_veiculo + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
    modal.showModal();
    $('#txt_titulo').html('Novo');
    $('#status').hide();
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txt_id').val('NOVO');
})

$('#btn_editar').click(function () {
    $('#txt_titulo').html('Editando');
    $('#btn_concluir').show();
});

$('#btn_detalhes').click(function () {
    $('#txt_titulo').html('Detalhes');
    $('#btn_concluir').hide();
});

function alterarCadastro() {
    modal.showModal();
    $('#status').show();
    $status = $('#checkbox:checked').val();
    $.ajax({
        url: 'src/Application/selecionar_veiculo.php',
        method: 'POST',
        data: {
            'id': $('#opt_veiculo:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {            
                $('#txt_id').val(result['cd_veiculo']);
                $('#txt_tipo').val(result['ds_tipo']);
                $('#txt_placa').val(result['ds_placa']);
                $('#txt_cor').val(result['ds_cor']);
               
                if (result['ds_situacao'] === '0') {
                    $('#chk_status').prop("checked", false)
                } else {
                    $('#chk_status').prop("checked", true)
                }
            listarVeiculos();
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
        url: 'src/Application/inserir_veiculo.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'tipo': $('#txt_tipo').val(),
            'placa': $('#txt_placa').val(),
            'cor': $('#txt_cor').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarVeiculos();
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
            url: 'src/Application/excluir_veiculo.php',
            method: 'POST',
            data: {
                'id': $('#opt_veiculo:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarVeiculos();
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});

listarVeiculos();