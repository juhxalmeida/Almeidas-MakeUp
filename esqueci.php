<?php

include("conexao.php");

if(isset($_POST['alterar'])){

    $email = $_POST['email'];

    $novaSenha =
    password_hash($_POST['novaSenha'],
    PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios
            SET senha='$novaSenha'
            WHERE email='$email'";

    if($conn->query($sql)){

        $mensagem = "Senha alterada com sucesso";

    }else{

        $mensagem = "Erro ao alterar senha";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Recuperar Senha</title>

<link rel="stylesheet" href="style.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="container">

<img src="imagens/logo.jpeg" class="logo">

<h1>Recuperar Senha</h1>

<form method="POST">

<input type="email"
name="email"
placeholder="Digite seu email"
required>

<input type="password"
name="novaSenha"
placeholder="Nova senha"
required>

<button name="alterar">
Alterar senha
</button>

</form>

<?php
if(isset($mensagem)){
    echo "<p class='sucesso'>$mensagem</p>";
}
?>

<div class="links">

<a href="login.php">
Voltar ao login
</a>

</div>

</div>

</body>

</html>