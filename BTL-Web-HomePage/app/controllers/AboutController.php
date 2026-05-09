<?php
class AboutController {
    public function index() {
        // Có thể lấy dữ liệu từ Model ở đây nếu cần
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/about.php'; // Bạn cần tạo file này
        require_once '../app/views/layouts/footer.php';
    }
}