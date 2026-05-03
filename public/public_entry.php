<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy URL hiện tại, nếu không có thì mặc định là 'home'
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

switch ($url) {
    case 'users':
    require_once '../app/controllers/AdminUserController.php';
    $app = new AdminUserController();
    $app->index();
    break;

    case 'user-edit':
    require_once '../app/controllers/AdminUserController.php';
    $app = new AdminUserController();
    $app->edit();
    break;

    case 'user-update':
    require_once '../app/controllers/AdminUserController.php';
    $app = new AdminUserController();
    $app->update();
    break;

    case 'user-lock':
    require_once '../app/controllers/AdminUserController.php';
    $app = new AdminUserController();
    $app->lock();
    break;

    case 'user-reset':
    require_once '../app/controllers/AdminUserController.php';
    $app = new AdminUserController();
    $app->resetPassword();
    break;

    case 'home':
        require_once '../app/controllers/HomeController.php';
        $app = new HomeController();
        $app->index();
        break;

    case 'login':
        require_once '../app/controllers/AuthController.php';
        $app = new AuthController();
        $app->login();
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