<?php
require_once "../app/models/UserModel.php";

class AdminUserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    // Hàm hỗ trợ hiện Toast thông báo nhanh
    private function setFlash($status, $message) {
        $_SESSION['auth_status'] = $status;
        $_SESSION['auth_message'] = $message;
    }

    public function index() {
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $users = $this->userModel->getUsers($limit, $offset);
        $total = $this->userModel->countUsers();

        // Gọi đầy đủ layout để không bị lỗi giao diện
        require_once '../app/views/layouts/header.php';
        include "../app/views/admin/users/index.php";
        require_once '../app/views/layouts/footer.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) die("User ID required");
        
        $user = $this->userModel->getUserById($id);
        
        require_once '../app/views/layouts/header.php';
        include "../app/views/admin/users/edit.php";
        require_once '../app/views/layouts/footer.php';
    }

    public function lock() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->lockUser($id);
            $this->setFlash('success', 'Đã thay đổi trạng thái tài khoản.');
        }
        header("Location: public_entry.php?url=users");
        exit();
    }

    public function resetPassword() {
        $id = $_POST['id'] ?? null;
        if (!$id) die("Invalid ID");

        $newPass = rand(100000, 999999);
        $this->userModel->resetPassword($id, $newPass);
        
        // Hiện popup riêng biệt cho mật khẩu mới vì cần Admin copy lại
        echo "<!DOCTYPE html><html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body style='background: #f4f6fa;'>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Mật khẩu mới',
                        text: 'Vui lòng cung cấp mật khẩu này cho người dùng: $newPass',
                        icon: 'info',
                        confirmButtonColor: '#3b82f6'
                    }).then(() => {
                        window.location.href = 'public_entry.php?url=users';
                    });
                });
              </script></body></html>";
        exit();
    }

public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // XỬ LÝ UPLOAD ẢNH
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            // Đảm bảo thư mục này tồn tại trong folder /public/
            $targetDir = "uploads/avatars/"; 
            if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
            
            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                // Cập nhật Database
                $this->userModel->updateAvatar($id, $targetFile);
                
                // CẬP NHẬT NGAY LẬP TỨC CHO HEADER NẾU LÀ CHÍNH MÌNH
                if ($id == $_SESSION['user_id']) {
                    $_SESSION['user_avatar'] = $targetFile; // Header sẽ load lại ảnh này
                }
            }
        }

        // Cập nhật thông tin chữ
        $this->userModel->updateUser($id, $fullname, $email, $role);
        
        // Cập nhật tên Header nếu là chính mình
        if ($id == $_SESSION['user_id']) {
            $_SESSION['user_name'] = $fullname;
        }

        $this->setFlash('success', 'Đã cập nhật dữ liệu thành công!');
        header("Location: public_entry.php?url=users");
        exit();
    }
}
}