function logout () {
    if (confirm('Realmente deseja sair?')){
        $.ajax({
            url: 'src/Application/logout.php',
            method: 'POST',
            dataType: 'json'
        }).done(function(result){
            if (result.status === 'sucesso'){
                window.location.href = 'index.php';
            } else {
                alert('Erro ao sair. Tente novamente.');
            }
        });
    }
}


if (typeof modal === 'undefined') {
    const modal = document.getElementById('modal');
} 


function listarUsuarios() {
    let tipo = 'listagem';

    if ($('#conteudo').data('loaded') === 'usuario') return;

    $.ajax({
        url: 'src/Application/selecionar_usuario.php',
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
                    '<div class="list-group"> <label class="list-group-item d-flex gap-2"> <input class="form-check-input flex-shrink-0" type="radio" name="opt_usuario" id="opt_usuario" value="' + result[i].cd_usuario + '" checked> <span>' + result[i].ds_usuario + ' <small class="d-block text-body-secondary">' + result[i].cd_usuario + '</small></span> </label></div>');
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
    $('#btn_concluir').show();
    $('#form input.form-control').val('');
    $('#txt_id').val('NOVO');
})

$('#btn_editar').click(function(){
    console.log('Editar');
    $('#txttitulo').html('Editando');
    $('#btn_concluir').show();
}); 

$('#btn_detalhes').click(function(){
    console.log('Detalhes');
    $('#txttitulo').html('Detalhes');
    $('#btn_concluir').hide();
    console.log($('#chk_status').val());
}); 

function alterarCadastro (){
    modal.showModal();    
    $('#status').show();
    $status = $('#checkbox:checked').val();
    console.log($status);

    $.ajax ({
        url: 'src/Application/selecionar_usuario.php',
        method: 'POST',
        data: {
            'id': $('#opt_usuario:checked').val(),
        },
        dataType: 'json'
    }).done(function (result){
        if (!result.erro){
            $('#txt_id').val(result['cd_usuario']);
            $('#txt_nome').val(result['ds_usuario']);
            $('#txt_email').val(result['ds_email']);
            $('#txt_senha').val(result['ds_senha']);
            $('#txt_cel').val(result['ds_celular']);
            $('#txt_cpf').val(result['ds_cpf']);
            $('#txt_nasc').val(result['ds_nascimento']);
            $('#txt_endereco').val(result['ds_endereco']);

            if (result['ds_situacao'] === '0') {
                console.log('Caiu');
                $('#chk_status').prop("checked", false)
            } else {
                $('#chk_status').prop("checked", true)
            }

            listarUsuarios();
        } else {
            console.log(result.erro);
        }
        
    });
};

$('#btn_fechar').click(function(){
    modal.close();
})

$('#form').submit(function (e){
    e.preventDefault();
    $.ajax({
        url: 'src/Application/inserir_usuario.php',
        method: 'POST',
        data: {
            'id': $('#txt_id').val(),
            'nome': $('#txt_nome').val(),
            'email': $('#txt_email').val(),
            'senha': $('#txt_senha').val(),
            'cel': $('#txt_cel').val(),
            'cpf': $('#txt_cpf').val(),
            'nasc': $('#txt_nasc').val(),
            'endereco': $('#txt_endereco').val(),
            'status': $('#chk_status').prop('checked') ? 1 : 0
        },
        dataType: 'json'
    }).done(function (result){
        if (!result.erro) {
            alert(result);
            modal.close();
            listarUsuarios();
        } else if (!result.erro_bd) {
            alert(result.erro);
        } else {
            console.log(result.erro);
        }
    });
});


$('#btn_exc').click(function(){
    if(confirm('Tem certeza que deseja excluir o cadastro?')){
        $.ajax ({
            url: 'src/Application/excluir_usuario.php',
            method: 'POST',
            data: {
                'id': $('#opt_usuario:checked').val(),
            },
            dataType: 'json'
        }).done(function(result){
            if (!result.erro) {
                alert(result);
                listarUsuarios();
            } else {
                alert('Não foi possível excluir o cadastro!');
                console.log(result.erro);
            }
        });
    }
    
});

listarUsuarios();