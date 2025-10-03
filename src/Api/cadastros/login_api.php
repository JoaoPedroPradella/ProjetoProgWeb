<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="..\..\..\assets\css\login.css"> 
    <title>LOGIN</title>
</head>

<body>
    <form method="POST" action="dados_login.php">
    <h1 class="h3 mb-3 fw-normal">LOGIN</h1>
    <div class="form-floating">
      <input type="email" class="form-control" name="txt_email" id="txt_email" placeholder="name@example.com" required>
      <label for="floatingInput" class="lbl" >Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="txt_token" id="txt_token" placeholder="Password" required>
      <label for="floatingPassword" class="lbl">Token</label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
     <a href="cad_usuario_api.php" class="btn btn-primary w-100 py-2" id="btn_cadastrar"> Cadastrar</a>
  </form>
 
</body>

</html>

