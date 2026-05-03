<?php
require_once "app/models/UserModel.php";

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

        include "app/views/admin/users/index.php";
    }

    // Form edit
    public function edit() {
        $id = $_GET['id'];
        $user = $this->userModel->getUserById($id);

        include "app/views/admin/users/edit.php";
    }

    // Update user
    public function update() {
        $this->userModel->updateUser(
            $_POST['id'],
            $_POST['username'],
            $_POST['email'],
            $_POST['role']
        );

        header("Location: public_entry.php?url=users");    }

    // Lock user
    public function lock() {
        $id = $_GET['id'];
        $this->userModel->lockUser($id);

        header("Location: public_entry.php?url=users");    }

    // Reset password
    public function resetPassword() {
        $id = $_POST['id'];
        $this->userModel->resetPassword($id, "123456");

        header("Location: public_entry.php?url=users");    }
}