<?php
// app/controllers/ProfileController.php

require_once __DIR__ . '/../models/UserModel.php';

class ProfileController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    private function requireAuth() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: public_entry.php?url=login');
            exit;
        }
    }

    public function index() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        
        // Sử dụng đúng hàm đã có trong UserModel của bạn
        $user = $this->userModel->getUserById($userId);
        
        if (!$user) {
            session_destroy();
            header('Location: public_entry.php?url=login');
            exit;
        }

        $pageTitle = "Hồ sơ cá nhân - CleanTech";
        
        // Gọi Layouts và View
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/profile/index.php';
        require_once '../app/views/layouts/footer.php';
    }

    public function update() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $data = [
            'full_name' => $_POST['full_name'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'phone'     => $_POST['phone'] ?? '',
            'gender'    => $_POST['gender'] ?? '',
            'birthdate' => $_POST['birthdate'] ?? '',
            'bio'       => $_POST['bio'] ?? ''
        ];

        if ($this->userModel->updateProfile($userId, $data)) {
            $_SESSION['user_name'] = $data['full_name'];
            $_SESSION['success_message'] = 'Cập nhật thông tin thành công!';
        }
        header('Location: public_entry.php?url=profile');
        exit;
    }

    public function changePassword() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        
        $hash = $this->userModel->getPasswordHash($userId);
        if (password_verify($current, $hash)) {
            $newHash = password_hash($new, PASSWORD_BCRYPT);
            $this->userModel->updatePassword($userId, $newHash);
            $_SESSION['success_message'] = 'Đổi mật khẩu thành công!';
        } else {
            $_SESSION['error_message'] = 'Mật khẩu hiện tại không đúng!';
        }
        header('Location: public_entry.php?url=profile');
        exit;
    }

    public function uploadAvatar() {
        $this->requireAuth();
        if (!empty($_FILES['avatar']['name'])) {
            $targetDir = "../public/assets/uploads/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            
            $fileName = time() . '_' . $_FILES["avatar"]["name"];
            $targetPath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetPath)) {
                $dbPath = "assets/uploads/" . $fileName;
                $this->userModel->updateAvatar($_SESSION['user_id'], $dbPath);
                $_SESSION['user_avatar'] = $dbPath;
                $_SESSION['success_message'] = 'Cập nhật ảnh thành công!';
            }
        }
        header('Location: public_entry.php?url=profile');
        exit;
    }
}