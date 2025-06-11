//const modal = document.querySelector("dialog#modal")

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

$("#carregarCliente").click(function(){
    $("#conteudo").load("cad_cliente.php");
})




// Carrega a listagem de clientes pela primeira vez
listarClientes();