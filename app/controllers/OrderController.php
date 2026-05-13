<?php
require_once '../app/models/ProductModel.php';
require_once '../app/models/OrderModel.php';

class OrderController {
    private $db;
    private $productModel;
    private $orderModel;

    public function __construct($db) { 
        $this->db = $db; 
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel($db);
    }

    private function requireAuth() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: public_entry.php?url=login'); exit;
        }
    }

    public function cartIndex() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'] ?? 0;
        // ĐÃ FIX: Lấy đúng ngăn tủ giỏ hàng của user hiện tại
        $cart = $_SESSION['user_cart'][$userId] ?? [];
        
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/cart/index.php'; 
        require_once '../app/views/layouts/footer.php';
    }

    public function addToCartAjax() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        // Nếu chưa đăng nhập, trả về trạng thái 'unauthorized'
        if (empty($_SESSION['user_id'])) {
            echo json_encode(['status' => 'unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['product_id'];
            $qty = (int)($_POST['quantity'] ?? 1);
            $userId = $_SESSION['user_id'];
            
            $product = $this->productModel->getProductById($id);
            if ($product) {
                if (!isset($_SESSION['user_cart'][$userId])) $_SESSION['user_cart'][$userId] = [];
                
                if (isset($_SESSION['user_cart'][$userId][$id])) {
                    $_SESSION['user_cart'][$userId][$id]['qty'] += $qty;
                } else {
                    $_SESSION['user_cart'][$userId][$id] = [
                        'id' => $product['id'], 'name' => $product['name'],
                        'price' => $product['price'], 'thumbnail' => $product['thumbnail'], 'qty' => $qty
                    ];
                }
                
                // Đếm tổng số lượng để gửi về cho Header
                $totalQty = array_sum(array_column($_SESSION['user_cart'][$userId], 'qty'));

                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Đã thêm vào giỏ hàng!',
                    'cart_count' => $totalQty
                ]);
            }
            exit;
        }
    }

    public function buyNow() {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['product_id'];
            $qty = (int)($_POST['quantity'] ?? 1);
            $userId = $_SESSION['user_id'];
            
            $product = $this->productModel->getProductById($id);
            if ($product) {
                if (!isset($_SESSION['user_cart'][$userId])) $_SESSION['user_cart'][$userId] = [];
                
                if (isset($_SESSION['user_cart'][$userId][$id])) {
                    $_SESSION['user_cart'][$userId][$id]['qty'] += $qty;
                } else {
                    $_SESSION['user_cart'][$userId][$id] = [
                        'id' => $product['id'], 'name' => $product['name'],
                        'price' => $product['price'], 'thumbnail' => $product['thumbnail'], 'qty' => $qty
                    ];
                }
                $_SESSION['selected_items'] = [$id]; 
                header('Location: public_entry.php?url=checkout'); exit;
            }
        }
    }

    public function checkout() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        
        $selectedItems = $_POST['selected_items'] ?? $_SESSION['selected_items'] ?? [];
        if (empty($selectedItems) || empty($_SESSION['user_cart'][$userId])) {
            header('Location: public_entry.php?url=cart'); exit;
        }

        require_once '../app/models/UserModel.php';
        $userModel = new UserModel($this->db);
        $user = $userModel->getUserById($userId);
        
        // Chỉ lấy những sản phẩm đã được tick chọn để đem qua trang Thanh toán
        $checkoutItems = [];
        foreach ($selectedItems as $id) {
            if (isset($_SESSION['user_cart'][$userId][$id])) {
                $checkoutItems[$id] = $_SESSION['user_cart'][$userId][$id];
            }
        }

        require_once '../app/views/layouts/header.php';
        require_once '../app/views/cart/checkout.php';
        require_once '../app/views/layouts/footer.php';
    }

    public function updateCartAjax() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $id = $_POST['id']; $newQty = (int)$_POST['qty'];
            $userId = $_SESSION['user_id'];
            
            $product = $this->productModel->getProductById($id);
            if ($product && $newQty > 0) {
                if ($newQty <= $product['stock_count']) {
                    $_SESSION['user_cart'][$userId][$id]['qty'] = $newQty;
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'max' => $product['stock_count']]);
                }
            }
            exit;
        }
    }

    public function removeFromCart() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $id = $_GET['id'] ?? 0;
        $userId = $_SESSION['user_id'] ?? 0;
        
        if (isset($_SESSION['user_cart'][$userId][$id])) { 
            unset($_SESSION['user_cart'][$userId][$id]); 
            $_SESSION['toast'] = "Đã xóa sản phẩm."; 
        }
        header('Location: public_entry.php?url=cart'); exit;
    }

    public function applyCouponAjax() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtolower(trim($_POST['code']));
            $userId = $_SESSION['user_id'] ?? 0;
            $cart = $_SESSION['user_cart'][$userId] ?? [];
            
            $total = 0; $hasApple = false;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
                $prod = $this->productModel->getProductById($item['id']);
                if ($prod && strtolower($prod['brand']) === 'apple') $hasApple = true;
            }

            $discount = 0; $msg = ''; $success = false;

            if ($code === 'voucher') {
                if ($total >= 4000000) { $discount = $total * 0.1; $msg = 'Voucher giảm 10%.'; $success = true; } 
                else { $msg = 'Đơn tối thiểu 4.000.000đ'; }
            } elseif ($code === 'coupon') {
                $discount = 500000; $msg = 'Coupon giảm 500.000đ.'; $success = true;
            } elseif ($code === 'apple') {
                if ($hasApple) { $discount = $total * 0.05; $msg = 'Giảm 5% cho đơn có Apple.'; $success = true; } 
                else { $msg = 'Chỉ áp dụng cho đơn Apple.'; }
            } else { $msg = 'Mã không hợp lệ!'; }

            if ($success) $_SESSION['discount'] = $discount; else unset($_SESSION['discount']);
            echo json_encode(['success' => $success, 'message' => $msg, 'discount' => $discount, 'newTotal' => $total - $discount]);
            exit;
        }
    }

    public function processCheckout() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'] ?? 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['user_cart'][$userId])) {
            
            $selectedItems = $_SESSION['selected_items'] ?? array_keys($_SESSION['user_cart'][$userId]);
            $checkoutItems = []; $totalPrice = 0;
            
            foreach ($selectedItems as $id) {
                if (isset($_SESSION['user_cart'][$userId][$id])) {
                    $item = $_SESSION['user_cart'][$userId][$id];
                    $checkoutItems[] = $item;
                    $totalPrice += ($item['price'] * $item['qty']);
                }
            }
            
            $discount = $_SESSION['discount'] ?? 0;
            $totalPrice = max(0, $totalPrice - $discount);

            $orderId = $this->orderModel->createOrder($userId, $totalPrice, $checkoutItems);
            
            // Chỉ xóa những sản phẩm ĐÃ THANH TOÁN khỏi giỏ hàng
            foreach ($selectedItems as $id) { unset($_SESSION['user_cart'][$userId][$id]); }
            
            unset($_SESSION['discount'], $_SESSION['selected_items']);
            $_SESSION['success_message'] = "Đặt hàng thành công! Mã đơn: #$orderId";
            header('Location: public_entry.php?url=my-orders'); exit;
        }
    }

    public function myOrders() {
        $this->requireAuth();
        $orders = $this->orderModel->getOrdersByUser($_SESSION['user_id']);
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/orders/my_orders.php';
        require_once '../app/views/layouts/footer.php';
    }
}
?>