<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
  margin: 0;
  font-family: Arial, sans-serif;
  display: flex;
}

/* Menu lateral */
.menu-lateral {
  width: 200px;
  height: 100vh;
  background-color: #f2f2f2;
  padding: 20px;
  box-sizing: border-box;
  position: fixed;
  left: 0;
  top: 0;
}

/* Conteúdo ao lado */
.conteudo {
  margin-left: 200px;
  padding: 20px;
  flex: 1;
}
</style>
<body>

    <main>    
    <div><?php include 'sistema.php';?></div>
    <div class="conteudo">
        teste
    </div>

    </main>
    

</body>
</html>