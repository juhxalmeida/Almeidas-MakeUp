<?php

session_start();

include("conexao.php");

if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios
        WHERE id = $id";

$resultado = $conn->query($sql);

$usuario = $resultado->fetch_assoc();

$produto = $_GET['produto'];
$preco = $_GET['preco'];

if(isset($_POST['finalizar'])){

    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    if($usuario['moedas'] >= $preco){

        $novoSaldo = $usuario['moedas'] - $preco;

        $update = "UPDATE usuarios
                   SET moedas = $novoSaldo
                   WHERE id = $id";

        $conn->query($update);

        echo "

        <script>

        alert('Compra realizada com sucesso! Seu produto está a caminho.');

        window.location='index.php';

        </script>

        ";

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
<html lang='pt-br'>

<head>

<meta charset='UTF-8'>

<title>Finalizar Compra</title>

<link rel='stylesheet' href='style.css'>

</head>

<body>

<div class='container'>

<h1>Finalizar Compra</h1>

<p>

Produto:
<b><?php echo $produto; ?></b>

</p>

<p>

Preço:
<b><?php echo $preco; ?> moedas</b>

</p>

<br>

<form method='POST'>

<input
type='email'
name='email'
placeholder='Seu e-mail'
required
>

<input
type='text'
name='telefone'
placeholder='Seu telefone'
required
>

<input
type='text'
name='endereco'
placeholder='Seu endereço'
required
>

<button name='finalizar'>

Finalizar Compra

</button>

</form>

</div>

</body>

</html>