<?php
session_start();

include("conexao.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios
            WHERE email='$email'";

    $resultado = $conn->query($sql);

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($senha, $usuario['senha'])){

            $_SESSION['id'] = $usuario['id'];

            header("Location: index.php");

        }else{

            $erro = "Senha incorreta";
        }

    }else{

        $erro = "Usuário não encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Login</title>

<link rel="manifest" href="manifest.json">

<meta name="theme-color" content="#63dfff">

<link rel="icon" href="logo-app.png">

<link rel="stylesheet" href="style.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="container">

<img src="imagens/logo.jpeg" class="logo">

<h1>Almeida's MakeUp</h1>

<?php
if(isset($_GET['cadastro'])){
    echo "
    <p class='sucesso'>
        Cadastro realizado com sucesso! Faça seu login.
    </p>
    ";
}
?>

<form method="POST">

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="senha"
placeholder="Senha"
required>

<button name="login">
Entrar
</button>

</form>

<?php
if(isset($erro)){
    echo "<p class='erro'>$erro</p>";
}
?>

<div class="links">

<a href="cadastro.php">
Criar conta
</a>

<a href="esqueci.php">
Esqueci minha senha
</a>
    </div>
    </div>

    </body>
    </html>
