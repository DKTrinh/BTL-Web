<?php
class OrderModel {
    private $db;
    
    public function __construct($db) { 
        $this->db = $db; 
    }

    public function createOrder($userId, $totalPrice, $cartItems) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
            $stmt->execute([$userId, $totalPrice]);
            $orderId = $this->db->lastInsertId();

            $stmtDetail = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $stmtDetail->execute([$orderId, $item['id'], $item['qty'], $item['price']]);
            }
            
            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            die("Lỗi đặt hàng: " . $e->getMessage());
        }
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>