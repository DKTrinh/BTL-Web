<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/helpers/SessionHelper.php';
require_once '../app/helpers/CsrfHelper.php';
require_once '../app/config/db_config.php';

SessionHelper::start();
$db = Database::connect();
$url = $_GET['url'] ?? 'home';

switch ($url) {
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
    case 'profile-check-pass':
        require_once '../app/controllers/ProfileController.php';
        $app = new ProfileController($db);
        if ($url === 'profile') $app->index();
        elseif ($url === 'profile-update') $app->update();
        elseif ($url === 'profile-password') $app->changePassword();
        elseif ($url === 'profile-avatar') $app->uploadAvatar();
        elseif ($url === 'profile-check-pass') $app->checkCurrentPassword();
        break;

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

    // ========== THÊM ROUTE CHO AJAX CONTACT ==========
    case 'contact/save':
        require_once '../app/controllers/ContactController.php';
        $contactCtrl = new ContactController($db);
        $contactCtrl->save();
        break;
    // =================================================

    case 'faqs':
        require_once '../app/controllers/FaqController.php';
        (new FaqController($db))->index();
        break;

    // ... (các case khác giữ nguyên, tôi cắt ngắn để dễ đọc)
    default:
        require_once '../app/views/layouts/header.php';
        echo "<div class='container my-5 text-center'><h1>404 - Trang không tồn tại</h1></div>";
        require_once '../app/views/layouts/footer.php';
        break;
}