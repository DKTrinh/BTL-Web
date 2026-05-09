<?php
class ContactController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $pageTitle = "Liên hệ - CleanTech";
        require_once '../app/views/layouts/header.php';
        // Gọi file view liên hệ
        require_once '../app/views/pages/contact.php';
        require_once '../app/views/layouts/footer.php';
    }
}