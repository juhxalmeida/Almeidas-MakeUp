<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios WHERE id = $id";

$resultado = $conn->query($sql);

$usuario = $resultado->fetch_assoc();

/* FINALIZAR COMPRA */

if(isset($_POST['finalizar'])){

    $email = $_POST['email'];

    $telefone = $_POST['telefone'];

    $endereco = $_POST['endereco'];

    $valorCompra = $_SESSION['valor_compra'];

    if($usuario['moedas'] >= $valorCompra){

        $novasMoedas = $usuario['moedas'] - $valorCompra;

        $update = "UPDATE usuarios
                   SET moedas = $novasMoedas
                   WHERE id = $id";

        $conn->query($update);

        $mensagem = "Compra realizada com sucesso, seu produto está a caminho.";

        unset($_SESSION['valor_compra']);

    }else{

        $mensagem = "Você não possui moedas suficientes.";

    }

}

/* GANHAR XP E MOEDAS */

if(isset($_GET['xp']) && isset($_GET['moedas'])){

    $xp = $_GET['xp'];

    $moedas = $_GET['moedas'];

    $novoXp = $usuario['xp'] + $xp;

    $novasMoedas = $usuario['moedas'] + $moedas;

    $update = "UPDATE usuarios
               SET xp = $novoXp,
               moedas = $novasMoedas
               WHERE id = $id";

    $conn->query($update);

    header("Location: index.php");
}

/* ADICIONAR AO CARRINHO */

if(isset($_GET['produto'])){

    $produto = $_GET['produto'];

    $preco = $_GET['preco'];

    $_SESSION['carrinho'][] = [

        "produto" => $produto,
        "preco" => $preco

    ];

    header("Location: carrinho.php");
}

/* COMPRAR DIRETO */

if(isset($_GET['comprar_direto'])){

    $preco = $_GET['preco'];

    if($usuario['moedas'] >= $preco){

        $_SESSION['valor_compra'] = $preco;

    }else{

        echo "
        <script>
            alert('Moedas insuficientes');
            window.location='index.php';
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Finalizar Compra</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h1>Finalizar Compra</h1>

        <?php

        if(isset($mensagem)){

            echo "<h3 class='sucesso'>$mensagem</h3>";

        }else{

        ?>

        <form method="POST">

            <input
                type="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
            >

            <input
                type="text"
                name="telefone"
                placeholder="Digite seu telefone"
                required
            >

            <input
                type="text"
                name="endereco"
                placeholder="Digite seu endereço"
                required
            >

            <button name="finalizar">
                Finalizar Compra
            </button>

        </form>

        <?php } ?>

        <br>

        <a href="index.php">

            <button>
                Voltar ao Site
            </button>

        </a>

    </div>

</body>

</html>
