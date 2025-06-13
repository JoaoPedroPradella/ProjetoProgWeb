const modal = document.getElementById('modal');

function listarClientes() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'cliente') return;

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


$("#btn_novo").click(function(){
    modal.showModal();
    $('#txttitulo').html('Novo');
    $('#status').hide();
})

$("#btn_edit").click(function alterarCadastro (){
    modal.showModal();
    $('#txttitulo').html('Editando');
    $('#status').show();
    $status = $('#checkbox:checked').val();
    console.log($status);

    $.ajax ({
        url: 'src/Application/selecionar_cliente.php',
        method: 'POST',
        data: {
            'id': $('#opt_cliente:checked').val(),
        },
        dataType: 'json'
    }).done(function (result){
        if (!result.erro){
            $('#txtid').val(result['cd_cliente']);
            $('#txtnome').val(result['ds_nome'])
            $('#txtcpf_cnpj').val(result['ds_cpf_cnpj'])
            $('#txttel').val(result['ds_tel'])
            $('#txtcep').val(result['ds_cep'])
            $('#txtuf').val(result['ds_uf'])
            $('#txtmunic').val(result['ds_municipio'])
            $('#txtlog').val(result['ds_logradouro'])

            if (result['tp_tipo'] )
            listarClientes();
        } else {
            console.log(result.erro);
        }
        
    });
});

$('#btn_fechar').click(function(){
    modal.close();
})

$('#form').submit(function (e){
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
        },
        dataType: 'json'
    }).done(function (result){
        modal.close();
        if (!result.erro) {
            alert(result);
            listarClientes();
        } else {
            alert('Existem erros no cadastro! Verifique')
            console.log(result.erro);
        }
    });
});

listarClientes();