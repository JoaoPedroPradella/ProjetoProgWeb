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