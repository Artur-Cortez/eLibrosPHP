<?php
$title = "eLibros - Perfil";
$content = "perfil_content.php";
include('_base.php');
?>

<!-- filepath: /path/to/project/perfil_content.php -->
<?php
include('config.php');
session_start();
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM usuario WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<main>
<form method="post" enctype="multipart/form-data" class="form-perfil">  
    <div>
        <figure>
            <?php if ($user['foto_de_perfil']) { ?>
                <img src="<?php echo $user['foto_de_perfil']; ?>" alt="Profile Picture"> 
            <?php } else { ?>
                <img src="static/images/usuario.png" alt="Profile Picture">
            <?php } ?>
        </figure>
        <div class="flex-column">
            <div class="flex-column">
                <label for="username">Nome de Usuário</label>
                <input id="username" type="text" value="<?php echo $user['nome']; ?>" disabled>
            </div>
            <div class="flex-column">
                <label for="email">E-mail</label>
                <input id="email" type="email" value="<?php echo $user['email']; ?>" disabled>
            </div>
            <div class="flex-column">
                <label for="fone">Telefone</label>
                <input id="fone" type="tel" value="<?php echo $user['telefone']; ?>" disabled>
            </div>
        </div>
        <div class="flex-column">
            <label for="genero">Identidade de gênero</label>
            <select id="genero" disabled>
                <option value="M" <?php if ($user['genero'] == 'M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if ($user['genero'] == 'F') echo 'selected'; ?>>Feminino</option>
                <option value="NB" <?php if ($user['genero'] == 'NB') echo 'selected'; ?>>Não-binário</option>
                <option value="PND" <?php if ($user['genero'] == 'PND') echo 'selected'; ?>>Prefiro não dizer</option>
            </select>
        </div>
        <div class="flex-column">
            <a id="visualizar-pedidos" href="pedidos.php">Visualizar pedidos</a> 
            <a id="editar-perfil" href="#">Editar perfil de usuário</a>
        </div>
    </div>
    <div>
        <div class="flex-column" style="justify-content: space-between">
            <div class="flex-column">
                <h3>Senha e autenticação</h3>
                <a id="alterar-senha" href="#">Alterar senha</a>
            </div>
            <hr>
            <div>
                <a id="excluir-conta" href="#">Excluir conta</a>
                <a id="desativar-conta" href="#">Desativar conta</a>
            </div>
        </div>
        <div class="divisor"></div>
        <div class="flex-column">
            <h3>Outras informações</h3>
            <div class="flex-column">
                <h4>Data de nascimento</h4>
                <p><?php echo $user['data_de_nascimento']; ?></p>
            </div>
            <div class="flex-column">
                <h4>Endereço</h4>
                <?php
                $sql = "SELECT * FROM endereco WHERE id = " . $user['endereco_id'];
                $result = $conn->query($sql);
                $endereco = $result->fetch_assoc();
                if ($endereco) {
                    echo '<p>' . $endereco['rua'] . ', ' . $endereco['numero'] . '</p>';
                } else {
                    echo '<a href="adicionar_endereco.php">Cadastrar endereço</a>';
                }
                ?>
            </div>
            <div class="flex-column">
                <h4>CPF</h4>
                <p><?php echo $user['CPF']; ?></p>
            </div>
        </div>
    </div>
</form>  
</main>