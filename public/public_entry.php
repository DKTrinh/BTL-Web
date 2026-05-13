<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Nhúng các file Core & Helpers
require_once '../app/helpers/SessionHelper.php';
require_once '../app/helpers/CsrfHelper.php';
require_once '../app/config/db_config.php'; 
require_once '../app/core/Database.php'; 

SessionHelper::start();
// Chú ý: Dùng getConnection() theo đúng tên class Database của bạn
$db = Database::getConnection();
$url = $_GET['url'] ?? 'home';

switch ($url) {
    // =====================================
    // 1. AUTH (ĐĂNG NHẬP / ĐĂNG KÝ)
    // =====================================
    case 'login':
    case 'register':
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $app = new AuthController($db);
        if ($url === 'login') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showLogin() : $app->login();
        elseif ($url === 'register') ($_SERVER['REQUEST_METHOD'] === 'GET') ? $app->showRegister() : $app->register();
        else { SessionHelper::destroy(); header('Location: public_entry.php?url=home'); exit; }
        break;

    // =====================================
    // 2. PROFILE (HỒ SƠ CÁ NHÂN)
    // =====================================
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

    // =====================================
    // 3. CÁC TRANG PUBLIC CHUNG
    // =====================================
    case 'home':
        require_once '../app/controllers/HomeController.php';
        (new HomeController($db))->index();
        break;

    case 'about':
        require_once '../app/controllers/AboutController.php';
        (new AboutController($db))->index();
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

    case 'solutions':
    case 'technology':
    case 'case-studies':
    case 'team':
        require_once '../app/controllers/PageController.php';
        $app = new PageController($db);
        if ($url === 'solutions') $app->solutions();
        else $app->technology(); 
        break;

    // =====================================
    // 4. SẢN PHẨM & CHI TIẾT SẢN PHẨM (FIX 404)
    // =====================================
    case 'products':
        require_once '../app/controllers/ProductController.php';
        (new ProductController($db))->index();
        break;

    case 'product-detail':
        require_once '../app/controllers/ProductController.php';
        (new ProductController($db))->detail();
        break;

    // =====================================
    // 5. GIỎ HÀNG & ĐƠN HÀNG (FIX 404)
    // =====================================
    case 'cart':
    case 'cart-add-ajax':   // Dòng quan trọng cho nút Thêm vào giỏ
    case 'cart-remove':
    case 'update-cart':
    case 'checkout':
    case 'checkout-process':
    case 'my-orders':
    case 'buy-now':         // Dòng quan trọng cho nút Mua ngay
        require_once '../app/controllers/OrderController.php';
        $orderApp = new OrderController($db);
        if ($url === 'cart') $orderApp->cartIndex();
        elseif ($url === 'cart-add-ajax') $orderApp->addToCartAjax(); // Gọi hàm Ajax
        elseif ($url === 'cart-remove') $orderApp->removeFromCart();
        elseif ($url === 'checkout') $orderApp->checkout();
        elseif ($url === 'buy-now') $orderApp->buyNow(); // Gọi hàm Mua ngay
        elseif ($url === 'checkout-process') $orderApp->processCheckout();
        elseif ($url === 'my-orders') $orderApp->myOrders();
        elseif ($url === 'update-cart') $orderApp->updateCartAjax();
        break;

    // =====================================
    // 6. QUẢN TRỊ VIÊN - QUẢN LÝ USER
    // =====================================
    case 'users':
    case 'user-edit':
    case 'user-update':
    case 'user-lock':
    case 'user-reset':
    case 'user-store':
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            echo "<script>alert('Từ chối truy cập!'); window.location.href='public_entry.php?url=home';</script>"; exit;
        }
        
        require_once '../app/controllers/AdminUserController.php';
        $adminApp = new AdminUserController($db);
        
        if ($url === 'users') {
            $adminApp->index();
        } elseif ($url === 'user-update') {
            $adminApp->update();
        } elseif ($url === 'user-lock') {
            $adminApp->lock();
        } elseif ($url === 'user-reset') {
            $adminApp->resetPassword();
        } elseif ($url === 'user-store') {
            $adminApp->store();
        } elseif ($url === 'user-edit') {
            $adminApp->edit();
        }
        break;

    // =====================================
    // 7. QUẢN TRỊ VIÊN - QUẢN LÝ SẢN PHẨM
    // =====================================
    case 'admin-products':
    case 'admin-product-store':
    case 'admin-product-update':
    case 'admin-product-delete':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            echo "<script>alert('Từ chối truy cập!'); window.location.href='public_entry.php?url=home';</script>"; exit;
        }
        require_once '../app/controllers/AdminProductController.php';
        $adminProdApp = new AdminProductController();
        if ($url === 'admin-products') $adminProdApp->index();
        elseif ($url === 'admin-product-store') $adminProdApp->store();
        elseif ($url === 'admin-product-update') $adminProdApp->update();
        elseif ($url === 'admin-product-delete') $adminProdApp->delete();
        break;

    // =====================================
    // 8. DEFAULT (TRANG 404)
    // =====================================
    default:
        require_once '../app/views/layouts/header.php';
        echo "<div class='container my-5 text-center'>
                <h1 class='display-1 text-danger fw-bold mt-5'>404</h1>
                <h2 class='text-muted mb-5'>Trang không tồn tại hoặc đang phát triển!</h2>
                <a href='public_entry.php?url=home' class='btn btn-primary fw-bold px-4 py-2'><i class='fas fa-home me-2'></i>Về trang chủ</a>
              </div>";
        require_once '../app/views/layouts/footer.php';
        break;
}