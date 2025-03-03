<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- {% block styles %}{% endblock %} -->
    <title>eLibros - Entrar</title>
    <!-- <link rel="stylesheet" href="{% static 'global.css' %}"> -->
    <link rel="stylesheet" href="static/global.css">
    <script src="static/global.js"></script>
</head>

<body class="bodylogin">
    <header class="headerlogin">
        <h1><a href="inicio.html"><img src="static/images/logoacesso.png"></a></h1>
    </header>
    <main>
        <section class="login">
            <figure><img src="static/images/vetorlogin.png"></figure>
            <div class="barraacesso"></div>
            <form action="login_acao.php" method="post">
                <div class="form-group">
                    <label for="username">Email</label>
                    <div class="input-icon">
                        <img src="static/images/icons/user.png" alt="User Icon" class="img-form">
                        <input type="text" id="username" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <img src="static/images/icons/lock.png" alt="Lock Icon" class="img-form">
                        <input type="password" id="password" name="password">
                        <img src="static/images/icons/olho.png" alt="Eye Icon" class="eye-icon">
                    </div>
                </div>
                <div class="form-group">
                    <label for="myCheckbox1">
                        <input type="checkbox" id="myCheckbox1" class="custom-checkbox">
                        <span class="checkbox-dot"></span>
                    </label>
                    <label for="remember" style="font-size: 14px; margin-top: 0em !important;">Lembre-se de mim</label>
                </div>
                <button type="submit">Entrar</button>
                <p>Não possui uma conta? <a href="register.html">Cadastrar</a></p>
            </form>
        </section>
    </main>
</body>
</html>