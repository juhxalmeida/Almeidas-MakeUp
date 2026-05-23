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

/* QUIZ DINÂMICO */

$perguntas = [

    [
        "pergunta" => "Qual produto hidrata os lábios?",
        "opcoes" => ["Gloss", "Base", "Pó compacto"],
        "correta" => "Gloss",
        "dificuldade" => "Fácil",
        "xp" => 10,
        "moedas" => 15
    ],

    [
        "pergunta" => "Qual produto é usado antes da maquiagem para hidratar a pele?",
        "opcoes" => ["Hidratante Facial", "Gloss", "Corretivo"],
        "correta" => "Hidratante Facial",
        "dificuldade" => "Médio",
        "xp" => 20,
        "moedas" => 30
    ],

    [
        "pergunta" => "Qual produto ajuda na remoção de células mortas da pele?",
        "opcoes" => ["Esfoliante Facial", "Base", "Gloss"],
        "correta" => "Esfoliante Facial",
        "dificuldade" => "Difícil",
        "xp" => 40,
        "moedas" => 50
    ],

    [
        "pergunta" => "Qual produto ajuda a uniformizar o tom da pele?",
        "opcoes" => ["Base", "Sabonete", "Gloss"],
        "correta" => "Base",
        "dificuldade" => "Fácil",
        "xp" => 10,
        "moedas" => 15
    ],

    [
        "pergunta" => "Qual produto reduz a oleosidade e sela a maquiagem?",
        "opcoes" => ["Pó Compacto", "Gloss", "Hidratante"],
        "correta" => "Pó Compacto",
        "dificuldade" => "Médio",
        "xp" => 20,
        "moedas" => 30
    ]

];

$quiz = $perguntas[array_rand($perguntas)];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Almeida's MakeUp</title>

    <link rel="stylesheet" href="style.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >

</head>

<body>

    <header>

        <div class="topo-logo">

            <img
                src="imagens/logo.jpeg"
                class="logo-header"
            >

            <h1>Almeida's MakeUp</h1>

        </div>

        <div class="menu-direita">

            <a href="carrinho.php" class="carrinho-link">

                🛒 Carrinho

                <?php

                if(isset($_SESSION['carrinho'])){

                    echo "(" . count($_SESSION['carrinho']) . ")";

                }else{

                    echo "(0)";
                }

                ?>

            </a>

            <a href="logout.php">
                Sair
            </a>

        </div>

    </header>

    <section class="perfil">

        <h2>
            Olá, <?php echo $usuario['nome']; ?>
        </h2>

        <div class="infos">

            <span>
                XP: <?php echo $usuario['xp']; ?>
            </span>

            <span>
                Moedas: <?php echo $usuario['moedas']; ?>
            </span>

        </div>

        <div class="barra">

            <div
                class="progresso"
                style="width: <?php echo $usuario['xp']; ?>%"
            >
            </div>

        </div>

    </section>

    <section class="cards">

        <div class="card">

            <img
                src="imagens/base.jpeg"
                class="produto-img"
            >

            <h3>Base</h3>

            <p>
                Cobertura natural e acabamento perfeito.
            </p>

            <span class="preco">
                50 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Base&preco=50">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=50">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/corretivo.jpeg"
                class="produto-img"
            >

            <h3>Corretivo</h3>

            <p>
                Alta cobertura para uma pele impecável.
            </p>

            <span class="preco">
                40 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Corretivo&preco=40">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=40">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/gloss.jpeg"
                class="produto-img"
            >

            <h3>Gloss</h3>

            <p>
                Brilho intenso e hidratação.
            </p>

            <span class="preco">
                30 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Gloss&preco=30">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=30">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/po.jpeg"
                class="produto-img"
            >

            <h3>Pó Compacto</h3>

            <p>
                Acabamento suave e natural.
            </p>

            <span class="preco">
                60 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Po Compacto&preco=60">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=60">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/sabonete.jpeg"
                class="produto-img"
            >

            <h3>Sabão Facial</h3>

            <p>
                Limpeza profunda e refrescante.
            </p>

            <span class="preco">
                45 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Sabonete Facial&preco=45">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=45">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/hidratante.jpeg"
                class="produto-img"
            >

            <h3>Hidratante Facial</h3>

            <p>
                Hidratação intensa para sua pele.
            </p>

            <span class="preco">
                70 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Hidratante Facial&preco=70">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=70">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <div class="card">

            <img
                src="imagens/esfoliante.jpeg"
                class="produto-img"
            >

            <h3>Esfoliante Facial</h3>

            <p>
                Renove sua pele com suavidade.
            </p>

            <span class="preco">
                80 moedas
            </span>

            <div class="botoes-produto">

                <a href="comprar.php?produto=Esfoliante Facial&preco=80">

                    <button>
                        Adicionar ao Carrinho
                    </button>

                </a>

                <a href="comprar.php?comprar_direto=1&preco=80">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

    </section>

    <section class="quiz">

        <h2>Quiz da Beleza</h2>

        <h3>
            Dificuldade:
            <?php echo $quiz['dificuldade']; ?>
        </h3>

        <p>
            <?php echo $quiz['pergunta']; ?>
        </p>

        <?php

        foreach($quiz['opcoes'] as $opcao){

            if($opcao == $quiz['correta']){

                echo "

                <a href='comprar.php?xp=".$quiz['xp']."
                &moedas=".$quiz['moedas']."'>

                <button>

                $opcao

                </button>

                </a>

                ";

            }else{

                echo "

                <button onclick=\"alert('Resposta errada')\">

                $opcao

                </button>

                ";
            }
        }

        ?>

    </section>

    <footer>

        <p>
            Almeida's MakeUp
        </p>

    </footer>

    <section class="sobre-container">

        <div class="sobre-card">

            <h2>Quem Somos</h2>

            <p>

                A Almeida's MakeUp nasceu do sonho de Júlia Rodrigues de Almeida,
                apaixonada pelo universo da beleza e skincare desde muito nova.

                O projeto começou como uma pequena ideia de criar uma marca moderna,
                elegante e divertida, capaz de unir maquiagem, autocuidado e
                gamificação em uma única experiência.

                Com dedicação, criatividade e amor pela autoestima feminina,
                a Almeida's MakeUp se tornou uma marca focada em valorizar
                a beleza natural e transformar a experiência de compra em algo
                leve, moderno e especial.

            </p>

        </div>

        <div class="sobre-card">

            <h2>Por que escolher a Almeida's MakeUp?</h2>

            <p>

                Na Almeida's MakeUp você encontra produtos modernos,
                sofisticados e pensados para realçar sua beleza natural.

                Além da qualidade dos produtos, nossa plataforma oferece
                uma experiência gamificada única, permitindo que clientes
                ganhem moedas, conquistas e benefícios através dos quizzes
                interativos da marca.

                Tudo foi desenvolvido para proporcionar uma experiência
                divertida, elegante e inovadora no universo da maquiagem.

            </p>

        </div>

    </section>

    <section class="contatos-container">

        <a href="email.php" class="contato-box">

            <h3>E-mail</h3>

            <p>
                contato@almeidasmakeup.com
            </p>

        </a>

        <a href="telefone.php" class="contato-box">

            <h3>Telefone</h3>

            <p>
                (11) 00000-0000
            </p>

        </a>

        <a href="instagram.php" class="contato-box">

            <h3>Instagram</h3>

            <p>
                @almeidasmakeup
            </p>

        </a>

    </section>

</body>

</html>