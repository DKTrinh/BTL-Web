<?php
// app/controllers/AdminFaqController.php
require_once '../app/models/FaqModel.php';

class AdminFaqController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        
        // Kiểm tra quyền Admin trước khi cho phép thao tác (Phân role)
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=home');
            exit();
        }
    }

    // Hiển thị danh sách FAQ có phân trang và bộ lọc trạng thái
    public function index() {
        $model = new FaqModel($this->db);
        
        $limit = 10; 
        $status = $_GET['status'] ?? null; // Lấy bộ lọc: 'pending' hoặc 'answered'
        $page = (int)($_GET['page'] ?? 1);
        $offset = ($page - 1) * $limit;

        $faqs = $model->getWithPagination($limit, $offset, $status);
        $total = $model->countAll($status);
        $countPending = $model->countAll('pending'); // Để hiện thông báo số câu chưa duyệt
        $totalPages = ceil($total / $limit);

        // Nạp view quản trị (Sử dụng template Srtdash)
        include '../app/views/admin/faq/index.php'; 
    }

    // Giao diện để Admin biên tập và trả lời
    public function edit() {
        $f_id = $_GET['id'] ?? null;
        if ($f_id) {
            $model = new FaqModel($this->db);
            $faq = $model->getById($f_id);
            include '../app/views/admin/faq/edit.php';
        }
    }

    // Xử lý cập nhật câu trả lời và thay đổi trạng thái Duyệt
    // app/controllers/AdminFaqController.php

public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $f_id = $_POST['f_id'];
        $title = trim($_POST['title']);
        $question = trim($_POST['question']);
        $answer = trim($_POST['answer']);
        $status = $_POST['status']; // Nhận giá trị 'answered' từ form ẩn

        // Chỉ duyệt nếu có câu trả lời
        if (!empty($answer)) {
            $model = new FaqModel($this->db);
            $model->update($f_id, $title, $question, $answer, $status);
            
            $_SESSION['success_message'] = "Đã trả lời và công bố câu hỏi thành công!";
        }
        
        header("Location: public_entry.php?url=admin/faq");
        exit();
    }
}

    // Xóa câu hỏi (Xử lý các trường hợp hỏi xàm)
    public function delete() {
        $f_id = $_GET['id'] ?? null;
        if ($f_id) {
            $model = new FaqModel($this->db);
            $model->delete($f_id);
        }
        header("Location: public_entry.php?url=admin/faq");
        exit();
    }
}