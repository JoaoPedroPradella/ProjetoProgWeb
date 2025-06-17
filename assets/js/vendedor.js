if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}


function listarVendedores() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'vendedor') return;

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
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_vendedor" id="opt_vendedor" value="' + result[i].cd_vendedor + '" checked> <span>' + result[i].ds_nome + ' <small class="d-block text-body-secondary">' + result[i].cd_vendedor + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
    modal.showModal();
    $('#txt_titulo').html('Novo');
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
    $.ajax({
        url: 'src/Application/selecionar_vendedor.php',
        method: 'POST',
        data: {
            'id': $('#opt_vendedor:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            // Chamada de função para primeiro realizar o ajax do selecionarCategoria para depois setar um valor no select
            $('#txt_id').val(result['cd_vendedor']);
            $('#txt_nome').val(result['ds_nome']);
            listarVendedores();
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
        url: 'src/Application/inserir_vendedor.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'nome': $('#txt_nome').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarVendedores();
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
            url: 'src/Application/excluir_vendedor.php',
            method: 'POST',
            data: {
                'id': $('#opt_vendedor:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarVendedores();
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});

listarVendedores();