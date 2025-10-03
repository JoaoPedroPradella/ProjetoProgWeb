$('#form').submit(function (e){
    console.log('chegou');
    e.preventDefault();
    $.ajax({
        url: 'inserir_usuario_api.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'nome': $('#txt_nome').val(),
            'email': $('#txt_email').val(),
            'senha': $('#txt_senha').val(),
            'status': 1
        },
        dataType: 'json'
    }).done(function (result){
        if (!result.erro) {
            alert("Usuário cadastrado com sucesso!");
            alert(result.token);
            window.location.href = 'login_api.php';
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});