<?php 
include('config.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="static/css/base.css" rel="stylesheet">
    <title>Início - Admin</title>
</head>
<body>
    <header>
        <h1><a href="inicioAdmin.html"><img src="static/images/logo.png"></a></h1>
            <nav>
                <ul class="navbar-ul">
                    <li>
                        <a class="nav-link-normal" href="manter.php?tabela=livro">Livros</a>
                    </li>
                    <li>
                        <a class="nav-link-normal" href="manter.php?tabela=cliente">Clientes</a>
                    </li>
                    <li>
                        <a class="nav-link-normal" href="manter.php?tabela=pedido">Pedidos</a>
                    </li>
                    <li>
                        <a class="nav-link-normal" href="manter.php?tabela=genero_literario">Gêneros</a>
                    </li>
                    <li>
                        <a class="nav-link-normal" href="manter.php?tabela=categoria">Categorias</a>
                    </li>

					<li>
                        <a class="nav-link-normal" href="manter.php?tabela=cupom">Cupons</a>
                    </li>

                    <li id="dropdown">
                        <div>
                            <div id="perfil">
                                <img src="static/images/usuario.png">
                            </div>
                            <ul id="espacinho">
                                <li>
                                    <a id="sair" href="sair do sistema rs">Sair</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
    </header>
    <?php

    include($content);
    ?>
    <footer class="admin">
        <p>© 2024 Entregadores. Todos os direitos reservados.</p>
    </footer>
</body>
</html>