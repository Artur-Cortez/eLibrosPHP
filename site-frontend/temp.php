<?php
include('config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_id = $_SESSION['session_id'] ?? session_id();
$cliente_id = $_SESSION['cliente_id'] ?? null;
$endereco_id = $_SESSION['endereco_id'] ?? null;

// Verificar se há itens no carrinho
$stmt = $conn->prepare("SELECT * FROM item_carrinho WHERE carrinho_id = ?");
$stmt->bind_param("i", $_SESSION['carrinho_id']);
$stmt->execute();
$result = $stmt->get_result();
$itens = $result->fetch_all(MYSQLI_ASSOC);

if (empty($itens)) {
    die(json_encode(["error" => "Carrinho vazio."]));
}

// Calcular valor total
$valor_total = array_sum(array_map(fn($item) => $item['preco'] * $item['quantidade'], $itens));

// Verificar se dados foram enviados via POST (checkout de cliente anônimo)
$nome = $_POST['nome'] ?? null;
$email = $_POST['email'] ?? null;
$rua = $_POST['rua'] ?? null;
$cidade = $_POST['cidade'] ?? "Cidade Padrão";
$estado = $_POST['estado'] ?? "SP"; // Estado padrão para evitar erro
$cep = $_POST['cep'] ?? "00000-000";
$bairro = $_POST['bairro'] ?? "Bairro Padrão";
$numero = $_POST['numero'] ?? 1; // Número 1 como padrão

// Garantir que todos os campos obrigatórios do endereço tenham valores
if (!$rua || !$cidade || !$estado || !$cep || !$bairro || !$numero) {
    error_log("Erro: Campos do endereço ausentes - Rua: $rua, Cidade: $cidade, Estado: $estado, CEP: $cep, Bairro: $bairro, Número: $numero");
    die(json_encode(["error" => "Dados de endereço incompletos."]));
}

// Criar endereço temporário se o cliente for anônimo e ainda não tiver endereço
if (!$cliente_id && ($nome && $email && $rua)) {
    $stmt = $conn->prepare("INSERT INTO cliente_temporario (session_id, nome, email, endereco) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $session_id, $nome, $email, $rua);
    $stmt->execute();
    $cliente_id = $stmt->insert_id;
}

// Criar endereço se ele não existir
if (!$endereco_id) {
    $stmt = $conn->prepare("INSERT INTO endereco (cep, uf, cidade, bairro, rua, numero) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $cep, $estado, $cidade, $bairro, $rua, $numero);
    
    if (!$stmt->execute()) {
        error_log("Erro ao inserir endereço: " . $stmt->error);
        die(json_encode(["error" => "Erro ao salvar endereço no banco."]));
    }

    $endereco_id = $stmt->insert_id;
}

// Garantir que endereco_id tenha um valor válido antes de continuar
if (!$endereco_id) {
    error_log("Erro: endereco_id ainda está NULL após tentativa de inserção.");
    die(json_encode(["error" => "Erro ao definir endereço para o pedido."]));
}

// Gerar número de pedido único
$numero_pedido = "PED-" . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

// Criar pedido
$stmt = $conn->prepare("INSERT INTO pedido (cliente_id, endereco_id, numero_pedido, valor_total, status_pedido, data_de_pedido, entrega_estimada) VALUES (?, ?, ?, ?, 'PRO', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY))");
$stmt->bind_param("iiss", $cliente_id, $endereco_id, $numero_pedido, $valor_total);
$stmt->execute();
$pedido_id = $stmt->insert_id;

if (!$pedido_id) {
    error_log("Erro ao criar pedido: " . $stmt->error);
    die(json_encode(["error" => "Erro ao criar pedido."]));
}

// Adicionar itens ao pedido
foreach ($itens as $item) {
    $stmt = $conn->prepare("INSERT INTO pedido_item (pedido_id, item_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $pedido_id, $item['id']);
    $stmt->execute();
}

// Limpar carrinho
$stmt = $conn->prepare("DELETE FROM item_carrinho WHERE carrinho_id = ?");
$stmt->bind_param("i", $_SESSION['carrinho_id']);
$stmt->execute();

$_SESSION['carrinho_numero_itens'] = 0;
$_SESSION['carrinho_maior_que_10'] = false;

header('Content-Type: application/json');
echo json_encode(["success" => true, "message" => "Compra finalizada.", "pedido_id" => $pedido_id, "numero_pedido" => $numero_pedido]);
exit;
?>
