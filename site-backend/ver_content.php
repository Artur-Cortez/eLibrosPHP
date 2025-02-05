<?php

$tabela = $_GET['tabela'];
$id = $_GET['id'];


$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tabela'";
$result = $conn->query($query);
$colunas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $colunas[] = $row['COLUMN_NAME'];
    }
}

$values = [];
$sql = "SELECT * FROM $tabela WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $values = $result->fetch_assoc();
}
?>


<main class="manter-livro">

    <div>
        <div>
            <h2><?php echo $tabela; ?></h2>
            <a href="manter.php?tabela=<?php echo $tabela; ?>">Voltar</a>
        </div>

        <form class="form-livro">
            <!--Campos da tabela (que não sejam capa, categoria e gênero)-->
            <?php foreach ($colunas as $col): ?>
            <div>
                <label for="<?php echo $col; ?>"><?php echo $col; ?></label>
                <input type="text" name="<?php echo $col; ?>" id="<?php echo $col; ?>" value="<?php echo $values[$col]; ?>" disabled>
            </div>
            <?php endforeach; ?>
        </form>
    </div>

    <div>
        <!--Se a tabela for livro, aqui teremos capa, categorias e generos-->
        <?php if ($tabela == 'livro'): ?>
            <?php
            $sql = "SELECT capa FROM livro WHERE id = $id";
            $result = $conn->query($sql);
            $capa = $result->fetch_assoc()['capa'];
            ?>
            <figure>
                <?php if ($capa): ?>
                    <img class="capa" src="<?php echo $capa; ?>">
                <?php else: ?>
                    <img class="capa" src="static/images/placeholder.png">
                <?php endif; ?>
            </figure>
            <h3>Categorias</h3>
            <div>
                <!-- Fetch and display categories -->
            </div>
            <h3>Gêneros</h3>
            <div>
                <!-- Fetch and display genres -->
            </div>
        <?php endif; ?>
    </div>

</main>