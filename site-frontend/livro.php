<?php
    include('config.php');
    $livro_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if (!$livro_id) {
        die("ID do livro não especificado");
    }
    $sql = "SELECT * FROM livro WHERE id = $livro_id";
    $result = $conn->query($sql);
    $livro = $result->fetch_assoc();

    if (!$livro) {
        die("Livro não encontrad    o");
    }
?>

<?php
$title = 'eLibros - ' . $livro['titulo'];
$content = "livro_content.php";
include('_base.php');
?>


