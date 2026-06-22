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

if(isset($_POST['publicar']) || isset($_POST['responder'])){

    $mensagem = $conn->real_escape_string($_POST['mensagem']);
    $usuarioForum = $usuario['nome'];

    $idResposta = isset($_POST['id_resposta'])
        ? (int) $_POST['id_resposta']
        : NULL;

    $conn->query("
        INSERT INTO forum(usuario, mensagem, id_resposta)
        VALUES('$usuarioForum', '$mensagem', ".($idResposta ? $idResposta : "NULL").")
    ");

    header("Location: index.php");
    exit();
}

/* EXCLUIR POSTAGEM */

if(isset($_GET['excluir'])){

    $idPost = (int) $_GET['excluir'];

    $conn->query("
    DELETE FROM forum
    WHERE id = $idPost
    ");

    header("Location: index.php");
    exit();
}

/* QUIZ DINÂMICO */

$perguntas = [

    [
        "pergunta" => "O que significa quando uma base possui cobertura construível?",
        "opcoes" => ["É resistente à água", "Pode ter a cobertura aumentada em camadas", "Tem proteção solar"],
        "correta" => "Pode ter a cobertura aumentada em camadas",
        "dificuldade" => "Fácil",
        "xp" => 8,
        "moedas" => 15
    ],

    [
        "pergunta" => "Qual ingrediente é frequentemente utilizado para proporcionar hidratação aos lábios em glosses modernos?",
        "opcoes" => ["Ácido salicílico", "Ácido hialurônico", "Peróxido de benzoíla"],
        "correta" => "Ácido hialurônico",
        "dificuldade" => "Difícil",
        "xp" => 37,
        "moedas" => 48
    ],

    [
        "pergunta" => "Qual componente é frequentemente utilizado para absorver a oleosidade em pós compactos?",
        "opcoes" => ["Colágeno", "Glicerina", "Sílica"],
        "correta" => "Sílica",
        "dificuldade" => "Médio",
        "xp" => 35,
        "moedas" => 30
    ],

    [
        "pergunta" => "Qual corretivo é frequentemente utilizado para neutralizar olheiras arroxeadas?",
        "opcoes" => ["Amarelado", "verde", "salmão"],
        "correta" => "Amarelado",
        "dificuldade" => "Fácil",
        "xp" => 10,
        "moedas" => 20
    ],

    [
        "pergunta" => "Esfoliantes químicos normalmente utilizam quais compostos?",
        "opcoes" => ["Silicone e Colágeno", "Ácidos como AHA e BHA", "Somente Queratina"],
        "correta" => "Ácidos como AHA e BHA",
        "dificuldade" => "Médio",
        "xp" => 45,
        "moedas" => 48
    ],
    [
    "pergunta" => "Qual componente da pele pode ser comprometido pelo uso frequente de sabonetes com pH muito alcalino?",
    "opcoes" => ["Barreira hidrolipídica", "Melanina", "Colágeno profundo"],
    "correta" => "Barreira hidrolipídica",
    "dificuldade" => "Difícil",
    "xp" => 52,
    "moedas" => 55
    ],

    [
    "pergunta" => "Qual mecanismo explica a ação do ácido hialurônico em hidratantes faciais?",
    "opcoes" => ["Remoção das células mortas da pele", "Estímulo direto à produção de melanina", "Capacidade higroscópica de atrair e reter moléculas de água"],
    "correta" => "Capacidade higroscópica de atrair e reter moléculas de água",
    "dificuldade" => "Difícil",
    "xp" => 40,
    "moedas" => 47
    ],

   [
    "pergunta" => "Em formulações hidratantes, os umectantes têm como principal função:",
    "opcoes" => ["Fotossensibilização Dérmica", "Atrair água para a camada córnea da pele", "Absorver oleosidade"],
    "correta" => "Atrair água para a camada córnea da pele",
    "dificuldade" => "Difícil",
    "xp" => 36,
    "moedas" => 45
    ],

];

//não deixa as perguntas se repetirem até elas acabarem, e se acabar volta do inicio

if(!isset($_SESSION['perguntas_usadas'])){
    $_SESSION['perguntas_usadas'] = [];
}

$disponiveis = [];

foreach($perguntas as $indice => $pergunta){

    if(!in_array($indice, $_SESSION['perguntas_usadas'])){

        $disponiveis[$indice] = $pergunta;
    }
}

if(count($disponiveis) == 0){

    $_SESSION['perguntas_usadas'] = [];

    $disponiveis = $perguntas;
}

$indiceQuiz = array_rand($disponiveis);

$quiz = $disponiveis[$indiceQuiz];

$_SESSION['perguntas_usadas'][] = $indiceQuiz;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Almeida's MakeUp</title>

    <link rel="stylesheet" href="style.css?v=2">

    <link rel="icon" href="logo-app.png">

    <link rel="manifest" href="manifest.json">

    <meta name="theme-color" content="#63dfff">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
.parceiros{
    width:100%;
    overflow:hidden;
    margin:50px 0;
}

.esteira{
    width:100%;
    overflow:hidden;
    position:relative;
}

.track{
    display:flex;
    gap:40px;
    width:max-content;
    animation: scroll 20s linear infinite;
    align-items:center;
}

.track img{
    width:180px;
    height:90px;
    object-fit:contain;
    flex-shrink:0;
}

/* ANIMAÇÃO DA ESTEIRA */
@keyframes scroll {
    0%{
        transform: translateX(0);
    }
    100%{
        transform: translateX(-50%);
    }
}
</style>

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

        <div id="mascote">
            <img
                src="imagens/juju.png"
                id="glossBot"
                alt="Juju"
            >
        </div>

        <a href="carrinho.php" class="carrinho-link">
             Carrinho
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

        <!-- BASE -->

        <div class="card">

            <a href="imagens/base.jpeg" target="_blank">

                <img
                    src="imagens/base.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Base&preco=50">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- CORRETIVO -->

        <div class="card">

            <a href="imagens/corretivo.jpeg" target="_blank">

                <img
                    src="imagens/corretivo.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Corretivo&preco=40">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- GLOSS -->

        <div class="card">

            <a href="imagens/gloss.jpeg" target="_blank">

                <img
                    src="imagens/gloss.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Gloss&preco=30">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- PÓ -->

        <div class="card">

            <a href="imagens/po.jpeg" target="_blank">

                <img
                    src="imagens/po.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Po Compacto&preco=60">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- SABONETE -->

        <div class="card">

            <a href="imagens/sabonete.jpeg" target="_blank">

                <img
                    src="imagens/sabonete.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Sabonete Facial&preco=45">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- HIDRATANTE -->

        <div class="card">

            <a href="imagens/hidratante.jpeg" target="_blank">

                <img
                    src="imagens/hidratante.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Hidratante Facial&preco=70">

                    <button class="comprar-agora">
                        Comprar Agora
                    </button>

                </a>

            </div>

        </div>

        <!-- ESFOLIANTE -->

        <div class="card">

            <a href="imagens/esfoliante.jpeg" target="_blank">

                <img
                    src="imagens/esfoliante.jpeg"
                    class="produto-img"
                >

            </a>

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

                <a href="finalizar.php?produto=Esfoliante Facial&preco=80">

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

        foreach($quiz['opcoes'] as $opcao){ //foreach: laço de repetição dos arrays

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

    </section> <!-- fim do quiz -->

<!-- ANÚNCIOS -->

<section class="parceiros">

<h1>Nossos parceiros:</h1>

<div class="esteira">

    <div class="track">

        <img src="imagens/dior.png">
        <img src="imagens/vizzela.png">
        <img src="imagens/rubyrose.png">
        <img src="imagens/lancome.png">
        <img src="imagens/maxlove.png">
        <img src="imagens/vult.png">
        <img src="imagens/fenzza.png">

        <!-- DUPLICA OS MESMOS PRA LOOP INFINITO -->
        <img src="imagens/dior.png">
        <img src="imagens/vizzela.png">
        <img src="imagens/rubyrose.png">
        <img src="imagens/lancome.png">
        <img src="imagens/maxlove.png">
        <img src="imagens/vult.png">
        <img src="imagens/fenzza.png">

    </div>

</div>

</section>

<section class="sobre-container">

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

    <section
    class="forum"
    style="
    width:90%;
    max-width:1000px;
    margin:60px auto;
    background:rgba(255,255,255,0.45);
    padding:35px;
    border-radius:25px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    ">

    <h2>Fórum da Comunidade!</h2>

    <form method="POST">

        <textarea name="mensagem"
    placeholder="Compartilhe uma dica ou faça uma pergunta..."
    required
    style="
    width:100%;
    height:120px;
    padding:15px;
    border:none;
    border-radius:15px;
    font-size:16px;
    margin-bottom:15px;
    "
    ></textarea>

        <button type="submit" name="publicar">
            Publicar
        </button>

    </form>

    <?php

$postagens = $conn->query("
SELECT *
FROM forum
WHERE id_resposta IS NULL
ORDER BY data_postagem DESC
");

while($post = $postagens->fetch_assoc()){

    $idPost = (int) $post['id'];

?>

<div class="postagem">

    <h4>
        <?php echo $post['usuario']; ?>
    </h4>

    <small>
        <?php echo date(
            "d/m/Y H:i",
            strtotime($post['data_postagem']) - 3 * 3600
        ); ?>
    </small>

    <p>
        <?php echo $post['mensagem']; ?>
    </p>

    <!-- FORMULÁRIO DE RESPOSTA -->
    <form method="POST" style="margin-top:10px;">
        <input type="hidden" name="id_resposta" value="<?php echo $post['id']; ?>">

        <input type="text" name="mensagem" placeholder="Responder..." required>

        <button type="submit" name="responder">
            Responder
        </button>
    </form>

    <!-- RESPOSTAS -->
    <?php
    $respostas = $conn->query("
        SELECT *
        FROM forum
        WHERE id_resposta = $idPost
        ORDER BY data_postagem ASC
    ");

    if($respostas->num_rows > 0){

        while($resp = $respostas->fetch_assoc()){
    ?>

        <div style="
            margin-left:30px;
            margin-top:10px;
            padding:10px;
            background:#f5f5f5;
            border-radius:10px;
        ">
            <strong><?php echo $resp['usuario']; ?></strong><br>
            <?php echo $resp['mensagem']; ?>
        </div>

    <?php
        }
    }
    ?>

    <?php if($post['usuario'] == $usuario['nome']){ ?>

        <a
            href="index.php?excluir=<?php echo $post['id']; ?>"
            onclick="return confirm('Excluir comentário?')"
        >
            <button>Excluir</button>
        </a>

    <?php } ?>

</div>

<?php } ?>

<div id="chatbot" style="display:none;">

    <div class="chat-header">
        💄 Juju Assistente!
    </div>

    <div id="mensagens">

        <div class="mensagem-bot">
            Olá! Sou a JujuGloss. Como posso ajudar?
        </div>

    </div>

    <input
        type="text"
        id="pergunta"
        placeholder="Digite sua pergunta..."
    >

    <button onclick="responder()">
        Enviar
    </button>

</div>

<script>

const glossBot = document.getElementById("glossBot");
const chatbot = document.getElementById("chatbot");

console.log(glossBot);
console.log(chatbot);

glossBot.addEventListener("click", ()=>{

    if(chatbot.style.display == "block"){

        chatbot.style.display = "none";

    }else{

        chatbot.style.display = "block";

    }

});

const respostas = {

"base":
"A base é utilizada para uniformizar o tom da pele e criar uma aparência mais homogênea.",

"base matte":
"A base matte possui acabamento sem brilho e é muito indicada para peles oleosas.",

"base glow":
"A base glow proporciona um acabamento luminoso e radiante à pele.",

"corretivo":
"O corretivo ajuda a disfarçar olheiras, manchas e pequenas imperfeições.",

"olheiras":
"Corretivos amarelados costumam ajudar a neutralizar olheiras arroxeadas.",

"gloss":
"O gloss proporciona brilho aos lábios e pode conter ingredientes hidratantes.",

"pó compacto":
"O pó compacto ajuda a selar a maquiagem e controlar a oleosidade.",

"po compacto":
"O pó compacto ajuda a selar a maquiagem e controlar a oleosidade.",

"hidratante":
"O hidratante ajuda a manter a pele saudável e reduz a perda de água.",

"ácido hialurônico":
"O ácido hialurônico possui grande capacidade de atrair e reter água na pele.",

"acido hialuronico":
"O ácido hialurônico possui grande capacidade de atrair e reter água na pele.",

"sabonete facial":
"O sabonete facial remove impurezas, suor, oleosidade e resíduos acumulados na pele.",

"manto ácido":
"O manto ácido é uma camada protetora natural que ajuda a proteger a pele.",

"manto acido":
"O manto ácido é uma camada protetora natural que ajuda a proteger a pele.",

"esfoliante":
"O esfoliante remove células mortas e promove renovação da pele.",

"pele oleosa":
"Peles oleosas costumam se beneficiar de produtos com acabamento matte e controle de brilho.",

"pele seca":
"Peles secas normalmente precisam de maior hidratação e produtos mais nutritivos.",

"acne":
"A acne é causada por diversos fatores, incluindo excesso de oleosidade e obstrução dos poros.",

"protetor solar":
"O protetor solar ajuda a proteger a pele contra os danos causados pela radiação UV.",

"skincare":
"Skincare é o conjunto de cuidados realizados para manter a saúde e a aparência da pele.",

"limpeza de pele":
"A limpeza da pele ajuda a remover impurezas e preparar a pele para outros produtos.",

"poros":
"Os poros são pequenas aberturas da pele responsáveis pela saída de suor e oleosidade.",

"maquiagem":
"A maquiagem pode ser utilizada para realçar características faciais e expressar estilo pessoal.",

"pele sensível":
"Peles sensíveis exigem produtos suaves e com menor potencial irritante.",

"pele sensivel":
"Peles sensíveis exigem produtos suaves e com menor potencial irritante.",

"primer":
"O primer ajuda a preparar a pele antes da maquiagem e pode aumentar sua durabilidade.",

"contorno":
"O contorno é utilizado para criar profundidade e definição em determinadas áreas do rosto.",

"iluminador":
"O iluminador destaca pontos estratégicos do rosto refletindo a luz.",

"blush":
"O blush adiciona cor e aspecto saudável às maçãs do rosto.",

"máscara de cílios":
"A máscara de cílios ajuda a destacar os cílios, proporcionando volume e definição.",

"mascara de cilios":
"A máscara de cílios ajuda a destacar os cílios, proporcionando volume e definição.",

"batom":
"O batom é utilizado para colorir e valorizar os lábios.",

"demaquilante":
"O demaquilante auxilia na remoção da maquiagem ao final do dia.",

"barreira hidrolipídica":
"A barreira hidrolipídica protege a pele contra agressões externas e perda excessiva de água.",

"barreira hidrolipidica":
"A barreira hidrolipídica protege a pele contra agressões externas e perda excessiva de água.",

"tewl":
"TEWL significa perda transepidérmica de água, um processo natural da pele.",

"umectantes":
"Umectantes são ingredientes que atraem água para as camadas superficiais da pele.",

"surfactantes":
"Surfactantes são responsáveis pela ação de limpeza presente em sabonetes e produtos de higiene.",

"subtom":
"O subtom da pele influencia na escolha correta da tonalidade da base.",

"pele mista":
"A pele mista apresenta áreas mais oleosas e outras mais secas.",

"cruelty free":
"Produtos cruelty free não são testados em animais.",

"vegano":
"Produtos veganos não possuem ingredientes de origem animal.",

"fps":
"FPS significa Fator de Proteção Solar.",

"uva":
"Os raios UVA estão relacionados ao envelhecimento precoce da pele.",

"uvb":
"Os raios UVB estão mais associados às queimaduras solares.",

"retinol":
"O retinol é um derivado da vitamina A utilizado em cuidados com a pele.",

"vitamina c":
"A vitamina C é um antioxidante muito utilizado para uniformizar e iluminar a pele.",

"niacinamida":
"A niacinamida auxilia no controle da oleosidade e fortalecimento da barreira cutânea."

};

function responder(){

    let pergunta =
    document.getElementById("pergunta")
    .value.toLowerCase();

    if(pergunta == "") return;

    let resposta =
    "Desculpe, ainda não sei responder essa pergunta.";

    for(let palavra in respostas){

        if(pergunta.includes(palavra)){

            resposta = respostas[palavra];
            break;

        }

    }

    let mensagens =
    document.getElementById("mensagens");

    mensagens.innerHTML +=
    "<div class='mensagem-user'>"+
    pergunta+
    "</div>";

    mensagens.innerHTML +=
    "<div class='mensagem-bot'>"+
    resposta+
    "</div>";

    document.getElementById("pergunta").value="";

    mensagens.scrollTop =
    mensagens.scrollHeight;

}

</script>


</body>

</html>
