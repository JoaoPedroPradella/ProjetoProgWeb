$('#btn_pedro').click(function () {
    let nome = prompt('Informe o nome:');
    let token = prompt('Informe o token:');
    // window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/pedro_api/menu_pedro.php';

    window.location.href = '/unc/ProjetoProgWeb/src/Api/entrada/pedro_api/menu_pedro.php?nome=' + nome + '&token=' + token;

});