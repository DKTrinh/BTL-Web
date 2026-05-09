<?php
// app/core/BaseController.php

class BaseController {
    protected $db;

    public function __construct($db = null) {
        $this->db = $db;
    }

    /**
     * Hàm render giao diện chuẩn MVC
     * @param string $viewPath Đường dẫn tới file view (ví dụ: 'pages/news')
     * @param array $data Dữ liệu truyền từ Controller ra ngoài View
     */
    public function render($viewPath, $data = []) {
        // Tự động giải nén mảng data thành các biến độc lập (VD: $data['newsList'] -> biến $newsList)
        if (!empty($data)) {
            extract($data);
        }

        $file = __DIR__ . "/../views/" . $viewPath . ".php";
        
        if (file_exists($file)) {
            // Kiểm tra xem đây là view của Admin hay Client
            $isAdminView = strpos($viewPath, 'admin/') !== false;

            if (!$isAdminView) {
                // Load Header cho Client
                require_once __DIR__ . '/../views/layouts/header.php';
            } else {
                // Nếu bạn có Header riêng cho Admin thì require ở đây
                // require_once __DIR__ . '/../views/admin/layouts/header.php';
            }
            
            // Load nội dung chính của trang
            require_once $file;
            
            if (!$isAdminView) {
                // Load Footer cho Client
                require_once __DIR__ . '/../views/layouts/footer.php';
            } else {
                // Nếu bạn có Footer riêng cho Admin thì require ở đây
                // require_once __DIR__ . '/../views/admin/layouts/footer.php';
            }
        } else {
            // Báo lỗi thân thiện nếu không tìm thấy file giao diện
            die("<div style='text-align:center; padding: 50px; font-family: sans-serif;'>
                    <h1 style='color: red;'>Lỗi Hệ Thống (404)</h1>
                    <p>Không tìm thấy tệp giao diện tại: <strong>{$viewPath}.php</strong></p>
                 </div>");
        }
    }

    /**
     * Hàm chuyển hướng trang (Redirect)
     */
    public function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}