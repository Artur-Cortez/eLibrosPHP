<header class="headerlogin">
    <h1><a href="index.php"><img src="static/images/logoacesso.png"></a></h1>
</header>
<main>
    <section class="cadastro">
    <form method="post" action="cadastro.php" class="formpessoal">
        <div class="infopessoal">
            <h2>Informações pessoais obrigatórias</h2>
    
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="form-group" style="display: flex;">                       
                    <div>
                        <label for="cpf">CPF</label>
                        <input id="cpf" type="text" name="cpf" class="form-control" placeholder="___.___.___-__" required>
                    </div>
                    <div>
                        <label for="telefone" style="margin-left: 1em;">Tel.</label>
                        <input id="telefone" type="text" name="telefone" class="form-control" placeholder="(xx) xxxxx-xxxx" required>
                    </div>
                </div>
                <div class="form-group" style="width: 40%;">
                    <label for="data_nasc">Data de nascimento</label>
                    <input id="data_nasc" type="date" name="data_nasc" class="form-control" required>
                </div>
            
        </div>
        <div class="barraacesso"></div>
        <div class="infologin">
            <h2>Criação da conta</h2>
            
                <div class="form-group">
                    <label for="username">Nome de usuário</label>
                    <div class="input-icon">
                    <input id="username" type="text" name="username" class="form-control" placeholder="Nome de usuário" required>
                    
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <input id="password" type="password" name="password" class="form-control" placeholder="Senha" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirme sua senha</label>
                    <div class="input-icon">
                        <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirme sua senha" required>
                    </div>
                </div>
            <button type="submit">Criar conta</button>
            <p>Já possui uma conta? <a href="login.php">Entrar</a></p>
        </div>
    </form>
    </section>
</main>