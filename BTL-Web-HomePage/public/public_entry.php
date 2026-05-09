<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Nhúng các file Core & Helpers
require_once '../app/helpers/SessionHelper.php';
require_once '../app/helpers/CsrfHelper.php';
require_once '../app/config/db_config.php'; 

SessionHelper::start();
$db = Database::connect();
$url = $_GET['url'] ?? 'home';

// ... (Giữ nguyên phần đầu file)

switch ($url) {
    // --- AUTH & PROFILE (Giữ nguyên) ---
    case 'login':
    case 'register':
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $app = new AuthController($db);
        if ($url === 'login') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showLogin() : $app->login();
        elseif ($url === 'register') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showRegister() : $app->register();
        else { SessionHelper::destroy(); header('Location: public_entry.php?url=home'); exit; }
        break;

    case 'profile':
    case 'profile-update':
    case 'profile-password':
    case 'profile-avatar':
        require_once '../app/controllers/ProfileController.php';
        $app = new ProfileController($db);
        $app->index(); 
        break;

    // --- CÁC TRANG PUBLIC (SỬA LỖI 404 TẠI ĐÂY) ---
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController($db))->index();
        break;

    case 'about':
        require_once '../app/controllers/AboutController.php';
        (new AboutController($db))->index();
        break;

    case 'products':
        require_once '../app/controllers/ProductController.php';
        (new ProductController($db))->index();
        break;

    case 'news':
        require_once '../app/controllers/NewsController.php';
        (new NewsController($db))->index();
        break;

    case 'contact':
        require_once '../app/controllers/ContactController.php';
        (new ContactController($db))->index();
        break;

    case 'faqs':
        require_once '../app/controllers/FaqController.php';
        (new FaqController($db))->index();
        break;

    // Các trang bổ sung từ menu Header để tránh 404
    case 'solutions':
    case 'technology':
    case 'case-studies':
    case 'team':
        require_once '../app/controllers/PageController.php';
        $app = new PageController($db);
        if ($url === 'solutions') $app->solutions();
        else $app->technology(); // hoặc các hàm tương ứng
        break;

    case 'users':
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: public_entry.php?url=home');
            exit;
        }
        // 2. Kiểm tra quyền Admin
        if ($_SESSION['user_role'] !== 'admin') {
            echo "<script>alert('Bạn không có quyền truy cập trang này!'); window.location.href='public_entry.php?url=home';</script>";
            exit;
        }
        // 3. NẠP FILE CONTROLLER (Thiếu dòng này sẽ bị lỗi)
        require_once '../app/controllers/AdminUserController.php';
        $app = new AdminUserController($db);
        $app->index();
        break;

    case 'users':
    case 'user-edit':
    case 'user-update':
    case 'user-lock':
    case 'user-reset':
        // 1. Kiểm tra quyền Admin trước khi cho phép vào các case này
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=home');
            exit;
        }

        require_once '../app/controllers/AdminUserController.php';
        $adminApp = new AdminUserController($db);

        // 2. Điều hướng đúng phương thức dựa trên tham số url
        if ($url === 'users') {
            $adminApp->index();
        } elseif ($url === 'user-edit') {
            $adminApp->edit(); // Giả sử hàm sửa của bạn tên là edit
        } elseif ($url === 'user-lock') {
            $adminApp->lock(); // Giả sử hàm khóa của bạn tên là lock
        } elseif ($url === 'user-reset') {
            $adminApp->resetPassword(); // Giả sử hàm reset của bạn tên là resetPassword
        } elseif ($url === 'user-update') {
            $adminApp->update();
        }
        break;

    default:
        require_once '../app/views/layouts/header.php';
        echo "<div class='container my-5 text-center'><h1>404 - Trang không tồn tại</h1></div>";
        require_once '../app/views/layouts/footer.php';
        break;
}