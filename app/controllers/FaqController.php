<?php
// app/controllers/FaqController.php
require_once '../app/models/FaqModel.php';

class FaqController {
    private $db;

    // Nhận kết nối PDO từ public_entry.php
    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $model = new FaqModel($this->db);
        
        // Lấy danh sách câu hỏi đã được Admin trả lời (status = 'answered')
        $faqs = $model->getAnswered(); 
        
        $data = [
            'faqs' => $faqs,
            'pageTitle' => "Hỏi đáp (FAQs) - CleanTech"
        ];

        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/faqs.php';
        require_once '../app/views/layouts/footer.php';
    }

    // Xử lý khi khách hàng gửi câu hỏi mới từ Form Y2K
    // app/controllers/FaqController.php
// app/controllers/FaqController.php
public function storeRequest() {
    // 1. Xóa bỏ mọi ký tự lạ hoặc khoảng trắng vô tình có trước đó
    if (ob_get_length()) ob_clean(); 

    // 2. Thiết lập header là JSON ngay lập tức
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $question = trim($_POST['question'] ?? '');

        if (!empty($title) && !empty($question)) {
            $model = new FaqModel($this->db);
            $result = $model->insert($title, $question);

            if ($result) {
                echo json_encode(['status' => 'success']);
                exit(); // CHẶN ĐỨNG HTML TẠI ĐÂY
            }
        }
        
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu trống']);
        exit(); 
    }
}

    
}