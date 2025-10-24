$('#form').submit(function (e){
    console.log('chegou');
    e.preventDefault();
    $.ajax({
        url: 'inserir_usuario_api.php',
        method: 'POST',
        data: {
            'nome': $('#txt_nome').val(),
            'email': $('#txt_email').val(),
            'senha': $('#txt_senha').val(),
            'status': 1
        },
        dataType: 'json'
    }).done(function (result){
        if (!result.erro) {
            alert(result.msg);
            if (result.token !== undefined && result.token !== null && result.token !== ''){
                alert('Copie: ' + result.token);
                window.location.href = '../../../index.php'
            }
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});