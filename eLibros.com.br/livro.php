<!-- filepath: /path/to/project/livro_content.php -->
<?php
    include('config.php');
    $livro_id = $_GET['id'];
    $sql = "SELECT * FROM livro WHERE id = $livro_id";
    $result = $conn->query($sql);
    $livro = $result->fetch_assoc();
?>

<?php
$title = $livro['titulo']; // Alterar para eLibros - titulo_do_livro
$content = "livro_content.php";
include('_base.php');
?>


