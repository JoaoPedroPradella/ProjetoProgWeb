<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>Usuários API</title>
    <link rel="stylesheet" href="..\..\..\assets\css\menu.css">
</head>

<body>
    <main id="main_usuario">
        <h1>Usuários</h1>
        <form class="" id="form">
            <label for="floatingPassword">Nome</label>
            <div class="form-floating mb-3">
                <input type="text" id="txt_nome" name="txt_nome" required class="form-control rounded-3">
            </div>
            <label for="floatingPassword">E-mail</label>
            <div class="form-floating mb-3">
                <input type="text" id="txt_email" name="txt_email" required class="form-control rounded-3">
            </div>
            <label for="floatingPassword">Senha</label>
            <div class="form-floating mb-3">
                <input input type="number" id="txt_senha" name="txt_senha" required class="form-control rounded-3">
            </div>
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="btn_concluir"
                name="btn_concluir">Cadastrar</button>
        </form>

    </main>
    <!-- Importando jquery -->
    <script src="..\..\..\vendor\js\jquery.js"></script>
    <script src="cad_usuarioJS.js"></script>
</body>

</html>