<?php
include('config.php');
header('Content-Type: application/json');
try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // In cart page, we need to use livro_id instead of id
    if ($data['action'] === 'adicionar' || $data['action'] === 'remover' || $data['action'] === 'deletar') {
        // Get livro_id from item_carrinho
        $stmt = $conn->prepare("SELECT livro_id FROM item_carrinho WHERE id = ?");
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        if (!$item) {
            throw new Exception('Item not found');
        }
        $livro_id = $item['livro_id'];
        $result->free();
        $stmt->close();
    } else {
        $livro_id = isset($data['id']) ? (int)$data['id'] : 0;
    }
    
    $action = $data['action']; // Essa variável está correta
    $quantidade = (int)$data['quantidadeAdicionada']; // Essa quantidade está correta
    

    // Validate inputs
    if (!$livro_id || !$action || $quantidade < 1) {
        throw new Exception('Invalid input');
    }

    // Get cart
    $stmt = $conn->prepare("SELECT id FROM carrinho WHERE session_id = ?");
    $stmt->bind_param("s", $_SESSION['session_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart = $result->fetch_assoc();
    if (!$cart) {
        throw new Exception('Cart not found');
    }
    $carrinho_id = $cart['id']; // Essa variável está correta
    $result->free();
    $stmt->close();

    // Get book price and check if book exists
    $stmt = $conn->prepare("SELECT preco FROM livro WHERE id = ?");
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc(); // Está retornando null
    
    if (!$book) {
        throw new Exception('Book not found');
    }
    $preco = $book['preco'];
    $result->free();
    $stmt->close();
    // Handle actions
    switch($action) {
        case 'adicionarAoCarrinho':
            // For initial add to cart, add the quantities
            $stmt = $conn->prepare("SELECT id, quantidade FROM item_carrinho WHERE carrinho_id = ? AND livro_id = ?");
            $stmt->bind_param("ii", $carrinho_id, $livro_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $existing_item = $result->fetch_assoc();
            $result->free();
            $stmt->close();
        
            if ($existing_item) {
                $new_quantity = $existing_item['quantidade'] + $quantidade;
                $stmt = $conn->prepare("UPDATE item_carrinho SET quantidade = ? WHERE carrinho_id = ? AND livro_id = ?");
                $stmt->bind_param("iii", $new_quantity, $carrinho_id, $livro_id);
            } else {
                $stmt = $conn->prepare("INSERT INTO item_carrinho (carrinho_id, livro_id, quantidade, preco) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $carrinho_id, $livro_id, $quantidade, $preco);
            }
            break;
        
        case 'adicionar':
            // For cart page updates, set exact quantity
            $stmt = $conn->prepare("UPDATE item_carrinho SET quantidade = ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $data['id']);
            break;

        case 'remover':
            // For cart page updates, set exact quantity
            $stmt = $conn->prepare("UPDATE item_carrinho SET quantidade = ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $data['id']);
            break;
            
        case 'deletar':                
            // Delete the item
            $stmt = $conn->prepare("DELETE FROM item_carrinho WHERE id = ? AND carrinho_id = ?");
            $stmt->bind_param("ii", $data['id'], $carrinho_id);
            if (!$stmt->execute()) {
                echo json_encode(['error' => 'Failed to delete item']);
                throw new Exception('Failed to delete item');
            }
            
            // Verify deletion
            if ($stmt->affected_rows === 0) {
                echo json_encode(['error' => 'Item not found or already deleted']);
                throw new Exception('Item not found or already deleted');
            }           

            break;
    }

    if ($action != 'deletar' && isset($stmt)) {
        if (!$stmt->execute()) {
            throw new Exception('Failed to execute statement: ' . $stmt->error);
        }
        $stmt->close();
    }

    // Get updated cart count
    $sql = "SELECT SUM(quantidade) as total FROM item_carrinho WHERE carrinho_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $carrinho_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_items = (int)($row['total'] ?? 0);
    $result->free();
    $stmt->close();

    $_SESSION['carrinho_numero_itens'] = $total_items;
    $_SESSION['carrinho_maior_que_10'] = $total_items >= 10;

    echo json_encode([
        'success' => true,
        'cartItemCount' => $total_items,
        'message' => 'Cart updated successfully'
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>