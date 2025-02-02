<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
  <title><?php echo $title; ?></title>
  <meta name="description" content="Site de vendas de livros somente brasileiros.">
  <meta name="author" content="Entregadores">
  <link rel="shortcut icon" type="image/x-icon" href="static/images/favicon.ico">
  <link rel="stylesheet" href="static/css/base.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
<header>
    <h1><a href="index.php"><img src="static/images/logo.png"></a></h1>
    <nav>
        <ul class="navbar-ul">
            <li><a class="nav-link-normal" href="index.php">Início</a></li>
            <li><a class="nav-link-normal" href="acervo.php">Acervo</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li id="dropdown">
                    <div>
                        <div id="perfil">
                            <?php if (isset($_SESSION['user_foto_de_perfil'])): ?>
                                <img src="<?php echo $_SESSION['user_foto_de_perfil']; ?>">
                            <?php else: ?>
                                <img src="static/images/usuario.png">
                            <?php endif; ?>
                        </div>
                        <ul id="espacinho">
                            <li><a href="perfil.php">Meu perfil</a></li>
                            <li><a id="sair" href="logout.php">Sair</a></li>
                        </ul>
                    </div>
                </li>
            <?php else: ?>
                <li><a id="cadastrar" class="nav-link-expand" href="cadastro.html">Cadastrar</a></li>
                <li><a id="entrar" class="nav-link-expand" href="login.html">Entrar</a></li>
            <?php endif; ?>
            <li>
                <a id="carrinho" class="nav-link" href="carrinho.php">
                    <img src="static/images/icons/carrinho.svg">
                    <?php if (isset($_SESSION['carrinho_maior_que_10']) && $_SESSION['carrinho_maior_que_10']): ?>
                        <span class="carrinho-quantidade">+9</span>
                    <?php else: ?>
                        <span class="carrinho-quantidade"><?php echo isset($_SESSION['carrinho_numero_itens']) ? $_SESSION['carrinho_numero_itens'] : 0; ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </nav>
</header>
<main>

<?php

include($content);
 ?>
</main>
<footer>
    <p>2024 Entregadores. Todos os direitos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="static/js/swiper.js"></script>
<script src="static/js/base.js"></script>
</body>
</html>