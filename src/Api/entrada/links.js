$('#btn_pedro').click(function () {
    let nome = prompt('Informe o nome:');
    let token = prompt('Informe o token:');

    window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/pedro_api/menu_pedro.php?nome=' + nome + '&token=' + token;

});

$('#btn_arthur').click(function () {
    let token = prompt('Informe o token:');

    window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/arthur_api/menu_arthur.php?token=' + token;
});