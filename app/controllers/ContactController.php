<?php
require_once __DIR__ . '/../models/ContactModel.php';

class ContactController {
    private $contactModel;

    public function __construct($db) {
        $this->contactModel = new ContactModel($db);
    }

    public function index() {
        require_once __DIR__ . '/../views/pages/contact.php';
    }

    public function save() {
        header('Content-Type: application/json');
        error_reporting(E_ALL);
        ini_set('display_errors', 0); // Tắt in lỗi trực tiếp ra output

        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                throw new Exception('Dữ liệu gửi lên không hợp lệ');
            }

            $fullname = trim($data['fullname'] ?? '');
            $email    = trim($data['email'] ?? '');
            $phone    = trim($data['phone'] ?? '');
            $subject  = trim($data['subject'] ?? '');
            $message  = trim($data['message'] ?? '');

            if (empty($fullname) || empty($email) || empty($message)) {
                throw new Exception('Vui lòng nhập họ tên, email và nội dung');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Email không đúng định dạng');
            }

            $result = $this->contactModel->saveContact($fullname, $email, $phone, $subject, $message);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Gửi liên hệ thành công']);
            } else {
                throw new Exception('Lưu dữ liệu thất bại');
            }
        } catch (Throwable $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}