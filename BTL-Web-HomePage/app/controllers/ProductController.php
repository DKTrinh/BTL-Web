<?php
class ProductController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/products.php'; // File nội dung riêng
        require_once '../app/views/layouts/footer.php';
    }
}