<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class AdminController {

    public function index() {
        SessionHelper::start();

        if ($_SESSION['role'] != 'admin') {
            die("Access denied");
        }

        $userModel = new UserModel();
        $users = $userModel->getAll();

        require_once '../app/views/admin/dashboard.php';
    }
}