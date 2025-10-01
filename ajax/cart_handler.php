<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/Cart.php';

header('Content-Type: application/json');

$cart = new Cart($pdo);
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'add':
            $product_id = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 1);
            
            if ($product_id <= 0) {
                throw new Exception('Érvénytelen termék');
            }
            
            $cart->addItem($product_id, $quantity);
            
            echo json_encode([
                'success' => true,
                'message' => 'Termék hozzáadva a kosárhoz',
                'cart_count' => $cart->getItemCount(),
                'cart_total' => $cart->getTotal()
            ]);
            break;

        case 'update':
            $product_id = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 1);
            
            if ($product_id <= 0) {
                throw new Exception('Érvénytelen termék');
            }
            
            $cart->updateQuantity($product_id, $quantity);
            
            echo json_encode([
                'success' => true,
                'message' => 'Kosár frissítve',
                'cart_count' => $cart->getItemCount(),
                'cart_total' => $cart->getTotal()
            ]);
            break;

        case 'remove':
            $product_id = (int)($_POST['product_id'] ?? 0);
            
            if ($product_id <= 0) {
                throw new Exception('Érvénytelen termék');
            }
            
            $cart->removeItem($product_id);
            
            echo json_encode([
                'success' => true,
                'message' => 'Termék eltávolítva',
                'cart_count' => $cart->getItemCount(),
                'cart_total' => $cart->getTotal()
            ]);
            break;

        case 'get':
            $items = $cart->getItems();
            
            echo json_encode([
                'success' => true,
                'items' => $items,
                'cart_count' => $cart->getItemCount(),
                'cart_total' => $cart->getTotal()
            ]);
            break;

        case 'clear':
            $cart->clear();
            
            echo json_encode([
                'success' => true,
                'message' => 'Kosár kiürítve',
                'cart_count' => 0,
                'cart_total' => 0
            ]);
            break;

        default:
            throw new Exception('Érvénytelen művelet');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}