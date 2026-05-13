<?php
require_once '../app/helpers/SessionHelper.php';
require_once '../app/helpers/CsrfHelper.php';
require_once '../app/models/UserModel.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
    }

    public function showLogin() {
        require_once '../app/views/auth/login_page.php';
    }

    public function showRegister() {
        require_once '../app/views/auth/register_page.php';
    }

    private function setFlash($status, $message) {
        $_SESSION['auth_status'] = $status;
        $_SESSION['auth_message'] = $message;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đồng bộ tên biến theo đúng trường 'fullname' của Database để tránh nhầm lẫn
            $fullname = trim($_POST['full_name'] ?? ($_POST['fullname'] ?? 'Thành viên mới'));
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // 1. Kiểm tra Email trống hoặc không hợp lệ cơ bản
            if (empty($email) || empty($password)) {
                $this->setFlash('error', 'Vui lòng điền đầy đủ thông tin!');
                header('Location: public_entry.php?url=home&login_error=1&tab=signup');
                exit();
            }

            // 2. Kiểm tra trùng Email
            if ($this->userModel->getUserByEmail($email)) {
                $this->setFlash('warning', 'Email đã tồn tại trên hệ thống!');
                header('Location: public_entry.php?url=home&login_error=1&tab=signup');
                exit();
            }

            // 3. Mã hóa mật khẩu (Luôn sinh ra chuỗi 60 ký tự)
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // 4. Gọi Model lưu vào hệ thống
            if ($this->userModel->registerUser($fullname, $email, $hashedPassword)) {
                $this->setFlash('success', 'Đăng ký tài khoản thành công!');
                header('Location: public_entry.php?url=home&login_error=1');
            } else {
                $this->setFlash('error', 'Lỗi hệ thống, không thể ghi dữ liệu!');
                header('Location: public_entry.php?url=home');
            }
            exit();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $user = $this->userModel->getUserByEmail($email);

// Phải chắc chắn là dùng $user['password'] viết thường, khớp với chữ password trong DB
if ($user && password_verify($password, $user['password'])) {   
                // KIỂM TRA TRẠNG THÁI KHÓA (status = 0)
                if ($user['status'] == 0) {
                    $this->setFlash('locked', 'Tài khoản của bạn đã bị khóa bởi Admin!');
                    header('Location: public_entry.php?url=home&login_error=1');
                    exit();
                }

                // ĐĂNG NHẬP THÀNH CÔNG -> Thiết lập Session cá nhân hóa
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['fullname'];
                
                // Đồng bộ Avatar nếu tài khoản đã thiết lập
                if (!empty($user['avatar'])) {
                    $_SESSION['user_avatar'] = $user['avatar'];
                }

                $this->setFlash('success', 'Chào mừng ' . $user['fullname'] . ' đã quay trở lại!');
                header('Location: public_entry.php?url=home'); 
                exit();
            } else {
                $this->setFlash('error', 'Sai tài khoản hoặc mật khẩu, vui lòng thử lại!');
                header('Location: public_entry.php?url=home&login_error=1');
                exit();
            }
        }
    }
}