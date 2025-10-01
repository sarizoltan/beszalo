<?php
class Cart {
    private $pdo;
    private $cart_id;
    private $session_id;
    private $user_id;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->session_id = session_id();
        $this->user_id = $_SESSION['user_id'] ?? null;
        $this->initCart();
    }

    private function initCart() {
        // Kosár keresése session_id vagy user_id alapján
        $stmt = $this->pdo->prepare("
            SELECT id FROM cart 
            WHERE session_id = :session_id 
            OR (user_id IS NOT NULL AND user_id = :user_id)
            ORDER BY created_at DESC LIMIT 1
        ");
        $stmt->execute([
            'session_id' => $this->session_id,
            'user_id' => $this->user_id
        ]);
        $cart = $stmt->fetch();

        if ($cart) {
            $this->cart_id = $cart['id'];
            // Frissítjük a session_id-t, ha bejelentkezett felhasználó
            if ($this->user_id) {
                $this->pdo->prepare("UPDATE cart SET session_id = :session_id, user_id = :user_id WHERE id = :cart_id")
                    ->execute([
                        'session_id' => $this->session_id,
                        'user_id' => $this->user_id,
                        'cart_id' => $this->cart_id
                    ]);
            }
        } else {
            // Új kosár létrehozása
            $stmt = $this->pdo->prepare("INSERT INTO cart (session_id, user_id) VALUES (:session_id, :user_id)");
            $stmt->execute([
                'session_id' => $this->session_id,
                'user_id' => $this->user_id
            ]);
            $this->cart_id = $this->pdo->lastInsertId();
        }
    }

    public function addItem($product_id, $quantity = 1) {
        // Ellenőrizzük, hogy létezik-e már a termék a kosárban
        $stmt = $this->pdo->prepare("
            SELECT id, quantity FROM cart_items 
            WHERE cart_id = :cart_id AND product_id = :product_id
        ");
        $stmt->execute([
            'cart_id' => $this->cart_id,
            'product_id' => $product_id
        ]);
        $item = $stmt->fetch();

        if ($item) {
            // Frissítjük a mennyiséget
            $new_quantity = $item['quantity'] + $quantity;
            $stmt = $this->pdo->prepare("
                UPDATE cart_items SET quantity = :quantity 
                WHERE id = :id
            ");
            $stmt->execute([
                'quantity' => $new_quantity,
                'id' => $item['id']
            ]);
        } else {
            // Új tétel hozzáadása
            $stmt = $this->pdo->prepare("
                INSERT INTO cart_items (cart_id, product_id, quantity) 
                VALUES (:cart_id, :product_id, :quantity)
            ");
            $stmt->execute([
                'cart_id' => $this->cart_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }
    }

    public function updateQuantity($product_id, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($product_id);
        }

        $stmt = $this->pdo->prepare("
            UPDATE cart_items SET quantity = :quantity 
            WHERE cart_id = :cart_id AND product_id = :product_id
        ");
        return $stmt->execute([
            'quantity' => $quantity,
            'cart_id' => $this->cart_id,
            'product_id' => $product_id
        ]);
    }

    public function removeItem($product_id) {
        $stmt = $this->pdo->prepare("
            DELETE FROM cart_items 
            WHERE cart_id = :cart_id AND product_id = :product_id
        ");
        return $stmt->execute([
            'cart_id' => $this->cart_id,
            'product_id' => $product_id
        ]);
    }

    public function getItems() {
        $stmt = $this->pdo->prepare("
            SELECT 
                ci.id,
                ci.product_id,
                ci.quantity,
                p.name,
                p.slug,
                p.price,
                p.sale_price,
                p.sale_price_start_date,
                p.sale_price_end_date,
                p.image_path,
                c.name as category_name,
                c.slug as category_slug,
                (CASE 
                    WHEN p.sale_price IS NOT NULL 
                    AND (p.sale_price_start_date IS NULL OR p.sale_price_start_date <= NOW())
                    AND (p.sale_price_end_date IS NULL OR p.sale_price_end_date >= NOW())
                    THEN p.sale_price 
                    ELSE p.price 
                END) as current_price
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            JOIN categories c ON p.category_id = c.id
            WHERE ci.cart_id = :cart_id
            ORDER BY ci.added_at DESC
        ");
        $stmt->execute(['cart_id' => $this->cart_id]);
        $items = $stmt->fetchAll();
        
        // JAVÍTÁS: Ne módosítsuk az image_path-ot itt, csak a frontend-en
        // A public/ rész megmarad, és a cart.js fogja kezelni
        
        return $items;
    }

    public function getItemCount() {
        $stmt = $this->pdo->prepare("
            SELECT SUM(quantity) as total 
            FROM cart_items 
            WHERE cart_id = :cart_id
        ");
        $stmt->execute(['cart_id' => $this->cart_id]);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function getTotal() {
        $stmt = $this->pdo->prepare("
            SELECT SUM(
                ci.quantity * 
                (CASE 
                    WHEN p.sale_price IS NOT NULL 
                    AND (p.sale_price_start_date IS NULL OR p.sale_price_start_date <= NOW())
                    AND (p.sale_price_end_date IS NULL OR p.sale_price_end_date >= NOW())
                    THEN p.sale_price 
                    ELSE p.price 
                END)
            ) as total
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = :cart_id
        ");
        $stmt->execute(['cart_id' => $this->cart_id]);
        $result = $stmt->fetch();
        return (float)($result['total'] ?? 0);
    }

    public function clear() {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
        return $stmt->execute(['cart_id' => $this->cart_id]);
    }
}