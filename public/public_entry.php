<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy URL hiện tại, nếu không có thì mặc định là 'home'
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

switch ($url) {
    case 'home':
        require_once '../app/controllers/HomeController.php';
        $app = new HomeController();
        $app->index();
        break;

    case 'login':
        require_once '../app/controllers/AuthController.php';
        $app = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $app->showLogin(); // Phải gọi hàm hiển thị view[cite: 11]
        } else {
            $app->login(); // Xử lý khi nhấn nút Login (POST)[cite: 11]
        }
        break;

    // Các trang menu khác dùng chung 1 Controller tạm thời
    case 'solutions':
    case 'technology':
    case 'case-studies':
    case 'team':
    case 'contact':
        require_once '../app/controllers/PageController.php';
        $app = new PageController();
        $app->show($url);
        break;

    default:
        echo "<h1>404 - Trang không tồn tại!</h1>";
        break;
}