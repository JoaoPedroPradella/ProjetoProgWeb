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
                    '<tr><td>' + result[i].cd_cliente + '</td><td>' + result[i].ds_nome + '</td></tr>');
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