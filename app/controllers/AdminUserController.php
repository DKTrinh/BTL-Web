<?php
require_once "../app/models/UserModel.php";

class AdminUserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Danh sách user
    public function index() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $users = $this->userModel->getUsers($limit, $offset);
        $total = $this->userModel->countUsers();

        include "../app/views/admin/users/index.php";
    }

    // Form edit
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) die("User ID required");

        $user = $this->userModel->getUserById($id);

        include "../app/views/admin/users/edit.php";
    }

    // Update user
    public function update() {
        $id = $_POST['id'] ?? null;
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'user';

        if (!$id) die("Invalid data");

        $this->userModel->updateUser($id, $username, $email, $role);

        header("Location: public_entry.php?url=users");
    }

    // Lock user
    public function lock() {
        $id = $_GET['id'] ?? null;
        if (!$id) die("User ID required");

        $this->userModel->lockUser($id);

        header("Location: public_entry.php?url=users");
    }

    // Reset password
    public function resetPassword() {
        $id = $_POST['id'] ?? null;
        if (!$id) die("Invalid ID");

        $newPass = rand(100000, 999999);
        $this->userModel->resetPassword($id, $newPass);

        echo "New password: " . $newPass;
    }
}