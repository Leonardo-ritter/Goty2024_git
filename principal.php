<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Portal de Jogos</title>
    <link rel="stylesheet" href="style_principal.css">
</head>

<body>
<?php
session_start();

// USUARIO LOCAGO
if (!isset($_SESSION['user_id'])) {
    //REDIRECIONA PARA LOGIN
    header('Location: login.html');
    exit;
}

// BOAS VINDAS
echo "<p>Bem-vindo, " . htmlspecialchars($_SESSION['username']) . "!</p>";
?>

<header class="cabecalho">
    <div class="cabecalho-logo">
        <h1>GOTY 2024</h1>  
    </div>
    <div class="botao-conectar-registrar">
        <button id="relatorio-btn">Relatório</button>
        <button id="logout-btn">Sair</button>
    </div>
</header>

<main class="imagem-fundo">
    <div class="imagem-fundo-escuro"></div>
</main>

<header id="segundo-cabecalho" class="segundo-cabecalho">
    <div class="botoes-centralizados">           
        <button id="blackmith" class="btn-estilo">Black Myth</button>
        <button id="astrobot" class="btn-estilo">Astro Bot</button>
        <button id="metaphor" class="btn-estilo">Metaphor</button>
        <button id="eldenring" class="btn-estilo">Elden Ring</button>
        <button id="finalfantasy" class="btn-estilo">Final Fantasy 7</button>
        <button id="balastro" class="btn-estilo">Balastro</button>
    </div>
</header>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/black-mith.jfif" alt="Imagem do Black Myth" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Black Myth Wukong</h2> 
            <p class="descricao-jogo">
                Inspirado em Jornada para o Oeste, um dos Quatro Grandes Romances Clássicos da mitologia chinesa, Black Myth: Wukong é descrito como um RPG de ação. O jogo está disponível para PS5 e PC (Steam).
            </p> 
        </div>
        <div class="button-votar"> 
            <button id="votar-1" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 101)">Votar</button>
        </div>
    </div>
</section>

<div id="1" class="cabecalhos-divisao"></div>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/astrobot.jfif" alt="Imagem do Astro Bot" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Astro Bot</h2> 
            <p class="descricao-jogo">
                Astro Bot é um charmoso jogo de plataforma 3D que salta aos olhos com suas decisões de design e uso dos recursos do controle DualSense. Disponível exclusivamente no PS5.
            </p>
        </div>
        <div class="button-votar"> 
            <button id="votar-2" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 102)">Votar</button>
        </div>
    </div>
</section>

<div id="2" class="cabecalhos-divisao"></div>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/metaphor.avif" alt="Imagem do Metaphor" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Metaphor: ReFantazio</h2> 
            <p class="descricao-jogo">
                Produzido pelo time de ouro de Persona, Metaphor mistura combates por turno e ação em tempo real. Disponível para PC (Steam), PlayStation e Xbox.
            </p>
        </div>
        <div class="button-votar"> 
            <button id="votar-3" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 103)">Votar</button>
        </div>
    </div>
</section>

<div id="3" class="cabecalhos-divisao"></div>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/eldenring.jfif" alt="Imagem do Elden Ring" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Elden Ring: Shadow of the Erdtree</h2> 
            <p class="descricao-jogo">
                A aguardada expansão de Elden Ring traz novas áreas e desafios no Reino das Sombras. Disponível para PC, PS4, PS5, Xbox One e Xbox Series S/X.
            </p>
        </div>
        <div class="button-votar"> 
            <button id="votar-4" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 104)">Votar</button>
        </div>
    </div>
</section>

<div id="4" class="cabecalhos-divisao"></div>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/finalfantasy.jfif" alt="Imagem do Final Fantasy 7" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Final Fantasy 7 Rebirth</h2> 
            <p class="descricao-jogo">
                O segundo jogo da trilogia reimagina o clássico de 1997 com um mundo aberto envolvente e sistema de combate refinado. Exclusivo para PS5.
            </p>
        </div>
        <div class="button-votar"> 
            <button id="votar-5" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 105)">Votar</button>  
        </div>
    </div>
</section>

<div id="5" class="cabecalhos-divisao"></div>

<section class="criar-linhas">
    <div class="conteudo">
        <img src="imagens/balastro.jfif" alt="Imagem do Balatro" class="imagem-direita">  
        <div class="texto">
            <h2 class="titulo-jogos">Balatro</h2> 
            <p class="descricao-jogo">
                Um pôquer roguelite com modificadores e multiplicadores que tornam a jogabilidade viciante. Disponível para PC, PlayStation, Xbox, Switch e dispositivos móveis.
            </p>
        </div>
        <div class="button-votar"> 
            <button id="votar-6" class="btn-estilo" onclick="validarRegistro(<?php echo $_SESSION['user_id']; ?>, 106)">Votar</button>
        </div>
    </div>
</section>

<script>
async function validarRegistro(userId, jogoId) {
    try {
        const respostaLogin = await fetch('verificar_login.php', { method: 'GET' });
        const status = await respostaLogin.json();

        if (status.logado) {
            //VERIFICA SE USUARIO VOTOU EM ALGUM JOGO
            const respostaVoto = await fetch('verificar_voto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `usuario_id=${userId}`
            });
            const votoStatus = await respostaVoto.text();

            if (votoStatus === 'Você já votou em outro jogo. Você pode votar apenas uma vez.') {
                alert("Você já votou em outro jogo. Você pode votar apenas uma vez.");
            } else {
                registrarVoto(userId, jogoId);
            }
        } else {
            alert("Você precisa estar logado para votar.");
            window.location.href = 'login.html';
        }
    } catch (error) {
        console.error('Erro ao validar login:', error);
    }
}


    function registrarVoto(userId, jogoId) {
        fetch('registrar_voto.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `usuario_id=${userId}&jogo_id=${jogoId}`
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error('Erro ao registrar voto:', error));
    }

    document.getElementById("logout-btn").addEventListener("click", function () {
        window.location.href = "logout.php"; // Redireciona para o arquivo de logout
    });

</script>
</body>

</html>
