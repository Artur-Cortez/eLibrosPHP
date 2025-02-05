<?php 

/* Essa será a página para adicionar um livro, autor, cupom, categoria, gênero 
Ela terá um formulário com os campos necessários para adicionar um novo registro
*/

$tabela = $_GET['tabela'];

$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tabela'";
$result = $conn->query($query);

$colunas_legiveis = [
    'nome' => 'Nome',
    'email' => 'Email',
    'senha' => 'Senha',
    'CPF' => 'CPF',
    'foto_de_perfil' => 'Foto de Perfil',
    'genero_literario' => 'Gênero',
    'data_de_nascimento' => 'Data de Nascimento',
    'telefone' => 'Telefone',
    'criado_em' => 'Criado em',
    'username' => 'Nome de Usuário',

    'titulo' => 'Título',
    'subtitulo' => 'Subtítulo',
    'data_de_publicacao' => 'Data de Publicação',
    'ano_de_publicacao' => 'Ano de Publicação',
    'ISBN' => 'ISBN',
    'sinopse' => 'Sinopse',
    'editora' => 'Editora',
    'preco' => 'Preço',
    'desconto' => 'Desconto',
    'quantidade' => 'Quantidade',
    'qtd_vendidos' => 'Quantidade Vendida',
];

$colunas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colunas[] = $row['COLUMN_NAME'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $values = [];
    foreach ($colunas as $coluna) {
        if ($coluna != 'id' && $coluna != 'capa') {
            if (($coluna == 'data_de_publicacao' || $coluna == 'desconto' || $coluna == 'subtitulo' || $coluna == 'sinopse') && empty($_POST[$coluna])) {
                $values[$coluna] = 'NULL';
            } else {
                $values[$coluna] = $_POST[$coluna];
            }
        }
    }

    if ($tabela == 'livro') {
        if (isset($_FILES['capa']) && $_FILES['capa']['error'] == 0) {
            $capa = 'uploads/' . basename($_FILES['capa']['name']);
            move_uploaded_file($_FILES['capa']['tmp_name'], $capa);
            $values['capa'] = $capa;
        }

        $columns = implode(", ", array_keys($values));
        $values = implode(", ", array_map(function($value) use ($conn) {
            return $value === 'NULL' ? $value : "'" . $conn->real_escape_string($value) . "'";
        }, array_values($values)));

        $sql = "INSERT INTO $tabela ($columns) VALUES ($values)";
        if ($conn->query($sql) === TRUE) {
            $livro_id = $conn->insert_id;

            // Associar autores
            if (isset($_POST['autores'])) {
                foreach ($_POST['autores'] as $autor_id) {
                    $conn->query("INSERT INTO livro_autor (livro_id, autor_id) VALUES ($livro_id, $autor_id)");
                }
            }

            // Associar categorias
            if (isset($_POST['categorias'])) {
                foreach ($_POST['categorias'] as $categoria_id) {
                    $conn->query("INSERT INTO livro_categoria (livro_id, categoria_id) VALUES ($livro_id, $categoria_id)");
                }
            }

            // Associar gêneros
            if (isset($_POST['genero_literarios'])) {
                foreach ($_POST['genero_literarios'] as $genero_id) {
                    $conn->query("INSERT INTO livro_genero (livro_id, genero_id) VALUES ($livro_id, $genero_id)");
                }
            }

            echo "Registro adicionado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $columns = implode(", ", array_keys($values));
        $values = implode(", ", array_map(function($value) use ($conn) {
            return $value === 'NULL' ? $value : "'" . $conn->real_escape_string($value) . "'";
        }, array_values($values)));

        $sql = "INSERT INTO $tabela ($columns) VALUES ($values)";
        if ($conn->query($sql) === TRUE) {
            echo "Registro adicionado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

?>

<main class="formulario">
    <div class="profile-container">
        <form method="post" enctype="multipart/form-data">
            <div class="profile-photo">
                <?php 
                if ($tabela == 'livro') {
                    foreach ($colunas as $coluna) {
                        if ($coluna == 'capa') {
                            echo "<label for='capa'>Capa</label>";
                            echo "<input type='file' name='capa' id='capa' accept='image/*'>";
                        }
                    }
                }
                ?>
            </div>
            <div class="profile-info">
                <?php 
                foreach ($colunas as $coluna) {
                    if ($coluna != 'id' && $coluna != 'capa') {
                        $label = isset($colunas_legiveis[$coluna]) ? $colunas_legiveis[$coluna] : $coluna;
                        echo "<label for='$coluna'>$label</label>";
                        echo "<input type='text' name='$coluna' id='$coluna'>";
                    }
                }

                if ($tabela == 'livro') {
                    $autores = $conn->query("
                    SELECT usuario.id as id, usuario.nome as nome FROM usuario
                    INNER JOIN autor ON usuario.id = autor.id_usuario
                    ");
                    $categorias = $conn->query("SELECT id, nome FROM categoria");
                    $genero_literarios = $conn->query("SELECT id, nome FROM genero_literario");

                    echo "<label for='autores[]'>Autores</label>";
                    echo "<select name='autores[]' id='autores' multiple>";
                    if ($autores->num_rows > 0) {
                        while ($autor = $autores->fetch_assoc()) {
                            echo "<option value='" . $autor['id'] . "'>" . $autor['nome'] . "</option>";
                        }
                    }
                    echo "</select>";

                    echo "<label for='categorias[]'>Categorias</label>";
                    echo "<select name='categorias[]' id='categorias' multiple>";
                    if ($categorias->num_rows > 0) {
                        while ($categoria = $categorias->fetch_assoc()) {
                            echo "<option value='" . $categoria['id'] . "'>" . $categoria['nome'] . "</option>";
                        }
                    }
                    echo "</select>";

                    echo "<label for='genero_literarios[]'>Gêneros</label>";
                    echo "<select name='genero_literarios[]' id='genero_literarios' multiple>";
                    if ($genero_literarios->num_rows > 0) {
                        while ($genero_literario = $genero_literarios->fetch_assoc()) {
                            echo "<option value='" . $genero_literario['id'] . "'>" . $genero_literario['nome'] . "</option>";
                        }
                    }
                    echo "</select>";
                }
                ?>
            </div>

            <div class="profile-actions">
                <button type="submit" class="save">Salvar alterações</button>
            </div>
        </form>
    </div>
</main>
<script src="static/js/base.js"></script>