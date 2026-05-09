<?php
class FaqController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $pageTitle = "Hỏi đáp (FAQs) - CleanTech";
        require_once '../app/views/layouts/header.php';
        // Gọi file view FAQ
        require_once '../app/views/pages/faqs.php';
        require_once '../app/views/layouts/footer.php';
    }
}