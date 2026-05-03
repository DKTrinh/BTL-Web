<?php
class AuthController {
    public function showLogin() {
        require_once '../app/views/auth/login_page.php';
    }

    public function showRegister() {
        // Trỏ về cùng một file giao diện modal
        require_once '../app/views/auth/register_page.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            SessionHelper::start();
            // ... Logic check tài khoản ...
            header('Location: ?url=home'); // Xong việc thì về nguồn[cite: 19]
            exit();
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ... Logic lưu tài khoản ...
            header('Location: ?url=home'); // Xong việc thì về nguồn[cite: 19]
            exit();
        }
    }
}