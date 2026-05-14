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
    // 1. AUTHENTICATION & PROFILE (Giữ nguyên)
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
    // 2. PUBLIC PAGES (Dành cho khách hàng)
    // ==========================================
    case 'home':
    case 'about':
    case 'products':
    case 'news':
    case 'contact':
    case 'faqs':
    case 'faq/user-request':
        if ($url === 'home') {
            require_once '../app/controllers/HomeController.php';
            (new HomeController($db))->index();
        } elseif ($url === 'about') {
            require_once '../app/controllers/AboutController.php';
            (new AboutController($db))->index();
        } elseif ($url === 'faqs' || $url === 'faq/user-request') {
            require_once '../app/controllers/FaqController.php';
            $faqApp = new FaqController($db);
            ($url === 'faqs') ? $faqApp->index() : $faqApp->userRequest();
        } else {
            $ctrl = ucfirst($url) . 'Controller';
            require_once "../app/controllers/$ctrl.php";
            (new $ctrl($db))->index();
        }
        break;

    // ==========================================
    // 3. QUẢN TRỊ VIÊN (TẬP TRUNG TẠI url=users)
    // ==========================================
    case 'users':
    case 'user-edit':
    case 'user-update':
    case 'user-lock':
    case 'user-reset':
    case 'user-store':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=home'); exit;
        }

        $tab = $_GET['tab'] ?? 'users';

        // 1. Nhánh FAQ
        if (strpos($tab, 'faq') !== false) {
            require_once '../app/models/FaqModel.php';
            require_once '../app/controllers/AdminFaqController.php';
            $faqAdmin = new AdminFaqController($db);

            if ($tab === 'faq-edit') {
                $faq = (new FaqModel($db))->getById($_GET['id']);
                include '../app/views/admin/faq/edit.php';
            } elseif ($tab === 'faq-update') {
                $faqAdmin->update(); // Sẽ redirect về tab=faq
            } elseif ($tab === 'faq-delete') {
                $faqAdmin->delete();
            } else {
                $faqs = (new FaqModel($db))->getAll();
                include '../app/views/admin/faq/index.php';
            }
        } 
        // 2. Nhánh Giới thiệu
        elseif ($tab === 'about' || $tab === 'about-update') {
            require_once '../app/controllers/AdminPageController.php';
            $pageAdmin = new AdminPageController($db);

            if ($tab === 'about-update') {
                $pageAdmin->updateAbout(); // Sẽ redirect về tab=about
            } else {
                require_once '../app/models/PageModel.php';
                $contents = (new PageModel($db))->getAboutContent();
                include '../app/views/admin/pages/about_edit.php';
            }
        }
        // 3. Nhánh Thành viên (Mặc định)
        else {
            require_once '../app/controllers/AdminUserController.php';
            $adminApp = new AdminUserController($db);
            if ($url === 'user-lock') $adminApp->lock();
            elseif ($url === 'user-update') $adminApp->update();
            else $adminApp->index();
        }
        break;

    // Các route bổ sung phục vụ cho các module Admin khác nếu cần
    case 'admin/about-update':
        require_once '../app/controllers/AdminPageController.php';
        (new AdminPageController($db))->updateAbout();
        break;

    default:
        require_once '../app/views/layouts/header.php';
        echo "<div class='container my-5 text-center'><h1>404 - Trang không tồn tại</h1></div>";
        require_once '../app/views/layouts/footer.php';
        break;
}