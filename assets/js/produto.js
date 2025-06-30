if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
}

$('#chk_situacao').click(function () {
    listarProdutos($('#chk_situacao').prop("checked"));
});

function listarProdutos(situacao) {
    if ($('#conteudo').data('loaded') === 'produto') return;

    let tipo = 'listagem';
    if (situacao === true) {
        situacao = '0'; // Marcado para listar apenas os inativos, passa 0 
    } else {
        situacao = '1'; // Desmarcado para listar apenas os inativos, passa 0
    }

    $.ajax({
        url: 'src/Application/selecionar_produto.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_produto" id="opt_produto" value="' + result[i].cd_produto + '" checked> <span>' + result[i].ds_produto + ' <small class="d-block text-body-secondary">' + result[i].cd_produto + '</small></span> </label></div>');
            }
        } else {
            console.log(result.erro);
        }
    });
}


$("#btn_novo").click(function () {
    selecionarCategoria();
    modal.showModal();
    $('#txt_titulo').html('Novo');
    $('#status').hide();
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
    $status = $('#checkbox:checked').val();
    console.log($status);
    $.ajax({
        url: 'src/Application/selecionar_produto.php',
        method: 'POST',
        data: {
            'id': $('#opt_produto:checked').val(),
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            // Chamada de função para primeiro realizar o ajax do selecionarCategoria para depois setar um valor no select
            selecionarCategoria(function () {
                $('#txt_id').val(result['cd_produto']);
                $('#txt_desc').val(result['ds_produto']);
                $('#txt_und').val(result['ds_unidade']);
                $('#txt_custo').val(result['vl_compra']);
                $('#txt_qtd').val(result['qt_estoque']);
                $('#txt_preco').val(result['vl_venda']);
                $('#slc_categoria').val(result['cd_categoria']);
                $('#slc_categoria option[value="' + result['cd_categoria'] + '"]').text(result['ds_categoria']);
                console.log($('#slc_categoria').val());
                if (result['ds_situacao'] === '0') {
                    $('#chk_status').prop("checked", false)
                } else {
                    $('#chk_status').prop("checked", true)
                }
            });
            listarProdutos($('#chk_situacao').prop("checked"));
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
        url: 'src/Application/inserir_produto.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'desc': $('#txt_desc').val(),
            'und': $('#txt_und').val(),
            'custo': $('#txt_custo').val(),
            'qtd': $('#txt_qtd').val(),
            'preco': $('#txt_preco').val(),
            'categ': $('#slc_categoria').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result) {
        if (!result.erro) {
            alert(result);
            modal.close();
            listarProdutos($('#chk_situacao').prop("checked"));
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
            url: 'src/Application/excluir_produto.php',
            method: 'POST',
            data: {
                'id': $('#opt_produto:checked').val(),
            },
            dataType: 'json'
        }).done(function (result) {
            if (!result.erro) {
                alert(result);
                listarProdutos($('#chk_situacao').prop("checked"));
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }

});

function selecionarCategoria(callback) {
    let tipo = 'listagem';
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
            $('#slc_categoria').empty();
            for (var i = 0; i < result.length; i++) {
                $('#slc_categoria').prepend(
                    '<option value="' + result[i].cd_categoria + '">' + result[i].ds_categoria + '</option>');
            }


            if (typeof callback === "function") {
                callback();
            }
        } else {
            console.log(result.erro);
        }
    });
}
