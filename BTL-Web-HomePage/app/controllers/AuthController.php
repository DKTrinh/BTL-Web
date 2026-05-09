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
            $full_name = trim($_POST['full_name'] ?? 'Thành viên mới');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($this->userModel->getUserByEmail($email)) {
                $this->setFlash('warning', 'Email đã tồn tại!');
                header('Location: public_entry.php?url=home&login_error=1&tab=signup');
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            if ($this->userModel->registerUser($full_name, $email, $hashedPassword)) {
                $this->setFlash('success', 'Đăng ký thành công!');
                header('Location: public_entry.php?url=home&login_error=1');
            } else {
                $this->setFlash('error', 'Lỗi hệ thống!');
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

        if ($user && password_verify($password, $user['password'])) {
            // KIỂM TRA TRẠNG THÁI KHÓA (status = 0)
            if ($user['status'] == 0) {
                $_SESSION['auth_status'] = 'locked'; // Footer của bạn sẽ bắt biến này để hiện thông báo đỏ
                $_SESSION['auth_message'] = 'Tài khoản của bạn đã bị khóa!';
                header('Location: public_entry.php?url=home&login_error=1');
                exit();
            }

            // ĐĂNG NHẬP THÀNH CÔNG
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['auth_status'] = 'success';
            $_SESSION['auth_message'] = 'Chào mừng ' . $user['fullname'] . '!';
            header('Location: public_entry.php?url=home'); 
            exit();
        } else {
            $_SESSION['auth_status'] = 'error';
            $_SESSION['auth_message'] = 'Sai email hoặc mật khẩu!';
            header('Location: public_entry.php?url=home&login_error=1');
            exit();
        }
    }
}
}