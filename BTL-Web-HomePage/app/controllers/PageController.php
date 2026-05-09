<?php
class PageController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function solutions() {
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/solutions.php';
        require_once '../app/views/layouts/footer.php';
    }

    public function technology() {
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/technology.php';
        require_once '../app/views/layouts/footer.php';
    }
}