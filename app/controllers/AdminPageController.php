<?php
require_once '../app/models/PageModel.php';

class AdminPageController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function editAbout() {
        $model = new PageModel($this->db);
        $contents = $model->getAboutContent();
        include '../app/views/admin/pages/about_edit.php';
    }

    // app/controllers/AdminPageController.php

public function updateAbout() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $model = new PageModel($this->db);
        if (isset($_POST['content'])) {
            foreach ($_POST['content'] as $key => $value) {
                $model->updateContent($key, trim($value));
            }
        }
        // Quay lại đúng tab About kèm thông báo thành công
        header("Location: public_entry.php?url=users&tab=about&status=success");
        exit();
    }
}
}