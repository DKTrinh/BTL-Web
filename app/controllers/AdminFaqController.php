<?php
require_once '../app/models/FaqModel.php';

class AdminFaqController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        $model = new FaqModel($this->db);
        $faqs = $model->getAll();
        include '../app/views/admin/faq/index.php';
    }

    public function edit() {
        $id = $_GET['id'];
        $faq = (new FaqModel($this->db))->getById($id);
        include '../app/views/admin/faq/edit.php';
    }

    public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new FaqModel($this->db))->update(
            $_POST['f_id'], 
            $_POST['title'], 
            $_POST['question'], 
            $_POST['answer'], 
            $_POST['status']
        );
        // Quay lại đúng tab FAQ thay vì rẽ sang trang admin/faq lẻ
        header("Location: public_entry.php?url=users&tab=faq&status=success");
        exit;
    }
}

    public function delete() {
        if (isset($_GET['id'])) {
            (new FaqModel($this->db))->delete($_GET['id']);
        }
        header("Location: public_entry.php?url=admin/faq");
        exit;
    }
}