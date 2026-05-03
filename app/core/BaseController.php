<?php
// app/core/BaseController.php
class BaseController {
    // Hàm render giao diện và truyền dữ liệu
    protected function view($view, $data = []) {
        extract($data); // Chuyển mảng thành các biến tự do
        $viewFile = "../app/views/" . $view . ".php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found.");
        }
    }
}