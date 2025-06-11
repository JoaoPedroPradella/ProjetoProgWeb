const modal = document.querySelector("dialog#modal")

function listarClientes() {
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
        console.log(result);
        if (!result.erro) {
            $('#lista').empty();

            for (var i = 0; i < result.length; i++) {
                $('#lista').prepend(
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="listGroupRadios" id="listGroupRadios1" value="" checked> <span>' + result[i].ds_nome + ' <small class="d-block text-body-secondary">' + result[i].cd_cliente + '</small></span> </label></div>');
            }
        } else {
            alert(result.erro);
        }
    });
}


$("#btn_novo").click(function(){
    console.log('teste');
    modal.showModal();
    $('#status').hide();
})

$('#btn_fechar').click(function(){
    modal.close();
})

$('#form').submit(function(){
    console.log('teste');
    e.preventDefault();
    $.ajax({
        url: 'src/Application/inserir_cliente.php',
        method: 'POST',
        data: {
            'codigo': $('#txtid').val(),
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
        alert('teste');
    });
});

// Carrega a listagem de clientes pela primeira vez
listarClientes();