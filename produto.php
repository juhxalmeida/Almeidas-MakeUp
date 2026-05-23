<?php

session_start();

if(!isset($_GET['produto'])){
    header("Location: index.php");
}

$produto = $_GET['produto'];

$imagem = $_GET['img'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title><?php echo $produto; ?></title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header>

        <div class="topo-logo">

            <img src="imagens/logo.jpeg"
            class="logo-header">

            <h1><?php echo $produto; ?></h1>

        </div>

        <a href="index.php">
            Voltar
        </a>

    </header>

    <div class="container">

        <img
            src="imagens/<?php echo $imagem; ?>"
            class="produto-zoom"
        >

        <h2><?php echo $produto; ?></h2>

        <p>

            Produto premium da Almeida's MakeUp,
            desenvolvido para realçar sua beleza
            com qualidade e sofisticação.

        </p>

    </div>

</body>

</html>