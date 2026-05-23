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

$total = 0;

/* REMOVER ITEM */

if(isset($_GET['remover'])){

    $indice = $_GET['remover'];

    unset($_SESSION['carrinho'][$indice]);

    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

    header("Location: carrinho.php");
}

/* COMPRAR ITEM INDIVIDUAL */

if(isset($_GET['comprar_item'])){

    $indice = $_GET['comprar_item'];

    $produto = $_SESSION['carrinho'][$indice];

    $preco = $produto['preco'];

    if($usuario['moedas'] >= $preco){

        $_SESSION['valor_compra'] = $preco;

        $_SESSION['indice_compra'] = $indice;

        header("Location: comprar.php");

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

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Carrinho</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header>

        <div class="topo-logo">

            <img
                src="imagens/logo.jpeg"
                class="logo-header"
            >

            <h1>Seu Carrinho</h1>

        </div>

        <a href="index.php">
            Voltar
        </a>

    </header>

    <section class="cards">

        <?php

        if(isset($_SESSION['carrinho']) &&
        count($_SESSION['carrinho']) > 0){

            foreach($_SESSION['carrinho'] as $indice => $item){

                $imagem = "";

                if($item['produto'] == "Base"){
                    $imagem = "imagens/base.jpeg";
                }

                elseif($item['produto'] == "Corretivo"){
                    $imagem = "imagens/corretivo.jpeg";
                }

                elseif($item['produto'] == "Gloss"){
                    $imagem = "imagens/gloss.jpeg";
                }

                elseif($item['produto'] == "Po Compacto"){
                    $imagem = "imagens/po.jpeg";
                }

                elseif($item['produto'] == "Sabonete Facial"){
                    $imagem = "imagens/sabonete.jpeg";
                }

                elseif($item['produto'] == "Hidratante Facial"){
                    $imagem = "imagens/hidratante.jpeg";
                }

                elseif($item['produto'] == "Esfoliante Facial"){
                    $imagem = "imagens/esfoliante.jpeg";
                }

                echo "

                <div class='card'>

                <img src='$imagem'
                class='produto-img'>

                <h3>".$item['produto']."</h3>

                <p>".$item['preco']." moedas</p>

                <div class='botoes-produto'>

                <a href='carrinho.php?comprar_item=$indice'>

                <button>

                Comprar Produto

                </button>

                </a>

                <a href='carrinho.php?remover=$indice'>

                <button class='comprar-agora'>

                Remover

                </button>

                </a>

                </div>

                </div>

                ";

                $total += $item['preco'];
            }

        }else{

            echo "<h2>Carrinho vazio</h2>";
        }

        ?>

    </section>

    <section class="quiz">

        <?php

        if(isset($_SESSION['carrinho']) &&
        count($_SESSION['carrinho']) > 0){

            echo "

            <h2>Total do Carrinho: $total moedas</h2>

            <a href='comprar.php?comprar_carrinho=1'>

            <button>

            Finalizar Tudo

            </button>

            </a>

            ";
        }

        ?>

    </section>

</body>

</html>
