

if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}

// modulo é para buscar a categoria e inserir no form de produtos
function listarCategorias() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'categoria') return;

    $.ajax({
        url: 'src/Application/selecionar_categoria.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_categoria" id="opt_categoria" value="' + result[i].cd_categoria + '" checked> <span>' + result[i].ds_categoria + ' <small class="d-block text-body-secondary">' + result[i].cd_categoria + '</small></span> </label></div>');
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
    console.log('Editar');
    $('#txt_titulo').html('Editando');
    $('#btn_concluir').show();
});

$('#btn_detalhes').click(function () {
    console.log('Detalhes');
    $('#txt_titulo').html('Detalhes');
    $('#btn_concluir').hide();
    console.log($('#chk_status').val());
});

function alterarCadastro() {
    modal.showModal();
    $('#status').show();

    $.ajax({
        url: 'src/Application/selecionar_categoria.php',
        method: 'POST',
        data: {
            'id': $('#opt_categoria:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            $('#txt_id').val(result['cd_categoria']);
            $('#txt_desc').val(result['ds_categoria']);
            listarCategorias();
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
        url: 'src/Application/inserir_categoria.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'desc': $('#txt_desc').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarCategorias();
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
                'id': $('#opt_categoria:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarCategorias();
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});

listarCategorias();