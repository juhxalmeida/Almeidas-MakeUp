<?php

include("conexao.php");

if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $senha = password_hash(
        $_POST['senha'],
        PASSWORD_DEFAULT //deixa a senha criptografada (linhas 10, 11 e 12)
    );

    $sql = "INSERT INTO usuarios(nome,email,senha)
            VALUES('$nome','$email','$senha')";

    $conn->query($sql);

    header("Location: login.php?cadastro=sucesso");
exit(); //localiza que os dados cadastrados vão pra pagina de login
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Cadastro</title>

    <link rel="stylesheet" href="style.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >

</head>

<body>

    <div class="container">

        <img src="imagens/logo.jpeg" class="logo">

        <h1>Cadastro</h1>

        <form method="POST">

            <input
                type="text"
                name="nome"
                placeholder="Nome"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
            >

            <input
                type="password"
                name="senha"
                placeholder="Senha"
                required
            >

            <button name="cadastrar">
                Cadastrar
            </button>

        </form>

        <div class="links">

            <a href="login.php">
                Já tenho conta
            </a>

        </div>

    </div>

</body>

</html>
