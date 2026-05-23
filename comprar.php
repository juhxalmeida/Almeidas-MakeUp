<?php
session_start();

if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

include("conexao.php");

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios
        WHERE id = $id";

$resultado = $conn->query($sql);

$usuario = $resultado->fetch_assoc();

/* QUIZ */

if(isset($_GET['xp']) && isset($_GET['moedas'])){

    $xp = $_GET['xp'];

    $moedas = $_GET['moedas'];

    $novoXP = $usuario['xp'] + $xp;

    $novasMoedas = $usuario['moedas'] + $moedas;

    $update = "UPDATE usuarios
               SET xp = $novoXP,
               moedas = $novasMoedas
               WHERE id = $id";

    $conn->query($update);

    echo "
    <script>
    alert('Você ganhou XP e moedas');
    window.location='index.php';
    </script>
    ";
}

/* ADICIONAR AO CARRINHO */

if(isset($_GET['produto']) && isset($_GET['preco'])){

    $produto = $_GET['produto'];

    $preco = $_GET['preco'];

    $_SESSION['carrinho'][] = [

        "produto" => $produto,
        "preco" => $preco

    ];

    echo "
    <script>
    alert('Produto adicionado ao carrinho');
    window.location='index.php';
    </script>
    ";
}

/* COMPRAR DIRETO */

if(isset($_GET['comprar_direto'])){

    $preco = $_GET['preco'];

    if($usuario['moedas'] >= $preco){

        $novoSaldo = $usuario['moedas'] - $preco;

        $update = "UPDATE usuarios
                   SET moedas = $novoSaldo
                   WHERE id = $id";

        $conn->query($update);

        echo "
        <script>
        alert('Compra realizada com sucesso');
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

/* FINALIZAR COMPRA */

if(isset($_GET['finalizar'])){

    $total = 0;

    foreach($_SESSION['carrinho'] as $item){

        $total += $item['preco'];
    }

    if($usuario['moedas'] >= $total){

        $novoSaldo = $usuario['moedas'] - $total;

        $update = "UPDATE usuarios
                   SET moedas = $novoSaldo
                   WHERE id = $id";

        $conn->query($update);

        $_SESSION['carrinho'] = [];

        echo "
        <script>
        alert('Compra finalizada');
        window.location='index.php';
        </script>
        ";

    }else{

        echo "
        <script>
        alert('Moedas insuficientes');
        window.location='carrinho.php';
        </script>
        ";
    }
}
?>