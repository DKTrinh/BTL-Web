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
    // ==========================================
    // 1. AUTHENTICATION
    // ==========================================
    case 'login':
    case 'register':
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $app = new AuthController($db);
        if ($url === 'login') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showLogin() : $app->login();
        elseif ($url === 'register') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showRegister() : $app->register();
        else { SessionHelper::destroy(); header('Location: public_entry.php?url=home'); exit; }
        break;

    // ==========================================
    // 2. USER PROFILE (Đã gộp các khối trùng)
    // ==========================================
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

    // ==========================================
    // 3. PUBLIC PAGES (Giữ nguyên logic của nhóm)
    // ==========================================
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
    case 'faq/user-request':
        require_once '../app/controllers/FaqController.php';
        (new FaqController($db))->userRequest();
        break;

    // ==========================================
    // 4. ADMIN DASHBOARD (TÍCH HỢP TAB: USERS, FAQ, ABOUT)
    // ==========================================
    case 'users':
    case 'user-edit':
    case 'user-update':
    case 'user-lock':
    case 'user-reset':
    case 'user-store':
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=home'); exit;
        }

        $tab = $_GET['tab'] ?? 'users';
        
        // Điều hướng dựa trên Tab hoặc URL hành động
        if ($tab === 'faq') {
            require_once '../app/models/FaqModel.php';
            $faqs = (new FaqModel($db))->getAll();
            include '../app/views/admin/faq/index.php';
        } elseif ($tab === 'faq-edit') {
            require_once '../app/models/FaqModel.php';
            $faq = (new FaqModel($db))->getById($_GET['id']);
            include '../app/views/admin/faq/edit.php';
        } elseif ($tab === 'faq-update' || $url === 'admin/faq/update') {
            require_once '../app/controllers/AdminFaqController.php';
            (new AdminFaqController($db))->update();
        } elseif ($tab === 'faq-delete' || $url === 'admin/faq/delete') {
            require_once '../app/controllers/AdminFaqController.php';
            (new AdminFaqController($db))->delete();
        } elseif ($tab === 'about') {
            require_once '../app/models/PageModel.php';
            $contents = (new PageModel($db))->getAboutContent();
            include '../app/views/admin/pages/about_edit.php';
        } else {
            // Mặc định nạp Quản lý Thành viên (Giữ nguyên logic của Team)
            require_once '../app/controllers/AdminUserController.php';
            $adminApp = new AdminUserController($db);
            if ($url === 'user-lock') $adminApp->lock();
            elseif ($url === 'user-reset') $adminApp->resetPassword();
            elseif ($url === 'user-store') $adminApp->store();
            elseif ($url === 'user-update') $adminApp->update();
            else $adminApp->index(); // Load index.php (users tab)
        }
        break;

    // Giữ lại các route lẻ của thành viên khác nếu họ dùng link trực tiếp
    case 'admin/about-edit':
    case 'admin/about-update':
        require_once '../app/controllers/AdminPageController.php';
        $pageApp = new AdminPageController($db);
        $url === 'admin/about-edit' ? $pageApp->editAbout() : $pageApp->updateAbout();
        break;

    case 'solutions':
    case 'technology':
    case 'case-studies':
    case 'team':
        require_once '../app/controllers/PageController.php';
        $app = new PageController($db);
        if ($url === 'solutions') $app->solutions();
        else $app->technology();
        break;

    default:
        require_once '../app/views/layouts/header.php';
        echo "<div class='container my-5 text-center'><h1>404 - Trang không tồn tại</h1></div>";
        require_once '../app/views/layouts/footer.php';
        break;
}