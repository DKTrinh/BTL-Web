<?php
// app/controllers/AdminFaqController.php
require_once 'app/models/FaqModel.php';

class AdminFaqController {
    public function index() {
        $model = new FaqModel();
        $limit = 10; 
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $faqs = $model->getWithPagination($limit, $offset);
        $total = $model->countAll();
        $totalPages = ceil($total / $limit);

        include 'app/views/admin/faq/list.php'; // Sử dụng template Srtdash 
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $q = $_POST['question'];
            $a = $_POST['answer'];
            // Server-side validation [cite: 63]
            if (!empty($q) && !empty($a)) {
                (new FaqModel())->insert($q, $a);
                header("Location: /admin/faq");
            }
        }
    }
}