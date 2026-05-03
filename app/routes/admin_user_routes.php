<?php
require_once "app/controllers/AdminUserController.php";

$controller = new AdminUserController();

$action = $_GET['action'] ?? 'users';

switch ($action) {
    case 'users':
        $controller->index();
        break;

    case 'edit':
        $controller->edit();
        break;

    case 'update':
        $controller->update();
        break;

    case 'lock':
        $controller->lock();
        break;

    case 'reset':
        $controller->resetPassword();
        break;
}