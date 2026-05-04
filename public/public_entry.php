<?php

$url = $_GET['url'] ?? 'users';

switch ($url) {

    case 'users':
        require_once '../app/controllers/AdminUserController.php';
        (new AdminUserController())->index();
        break;

    case 'user-edit':
        require_once '../app/controllers/AdminUserController.php';
        (new AdminUserController())->edit();
        break;

    case 'user-update':
        require_once '../app/controllers/AdminUserController.php';
        (new AdminUserController())->update();
        break;

    case 'user-lock':
        require_once '../app/controllers/AdminUserController.php';
        (new AdminUserController())->lock();
        break;

    case 'user-reset':
        require_once '../app/controllers/AdminUserController.php';
        (new AdminUserController())->resetPassword();
        break;

    default:
        echo "404 Not Found";
}