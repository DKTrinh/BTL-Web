<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/NewsModel.php';

class AdminNewsController extends BaseController {
    private $newsModel;

    public function __construct($db) {
        parent::__construct($db);
        // Bảo mật: Chỉ admin mới được vào
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=login');
            exit();
        }
        $this->newsModel = new NewsModel($this->db);
    }

    // Trang danh sách tin tức
    public function index() {
        $keyword = $_GET['search'] ?? '';
        if (!empty($keyword)) {
            $news = $this->newsModel->search($keyword);
        } else {
            $news = $this->newsModel->getAllNews();
        }
        $this->render('admin/news/index', ['news' => $news, 'keyword' => $keyword]);
    }

    // Trang giao diện thêm mới
    public function create() {
        $this->render('admin/news/create');
    }

    // Xử lý lưu tin tức mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleUpload();
            
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'badge' => $_POST['badge'],
                'image' => $imagePath
            ];

            if ($this->newsModel->create($data)) {
                $_SESSION['success'] = "Thêm tin tức thành công!";
            }
            header('Location: public_entry.php?url=admin/news');
        }
    }

    // Trang giao diện chỉnh sửa
    public function edit() {
        $id = $_GET['id'] ?? null;
        $item = $this->newsModel->getById($id);
        if (!$item) {
            die("Tin tức không tồn tại.");
        }
        $this->render('admin/news/edit', ['news' => $item]);
    }

    // Xử lý cập nhật tin tức
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $oldItem = $this->newsModel->getById($id);
            
            // Nếu có upload ảnh mới thì dùng ảnh mới, không thì giữ ảnh cũ
            $imagePath = $this->handleUpload() ?: $oldItem['image'];

            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'badge' => $_POST['badge'],
                'image' => $imagePath
            ];

            if ($this->newsModel->update($id, $data)) {
                $_SESSION['success'] = "Cập nhật thành công!";
            }
            header('Location: public_entry.php?url=admin/news');
        }
    }

    // Xử lý xóa
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id && $this->newsModel->delete($id)) {
            $_SESSION['success'] = "Đã xóa tin tức.";
        }
        header('Location: public_entry.php?url=admin/news');
    }

    // Hàm hỗ trợ upload ảnh
    private function handleUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/uploads/';
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                return $fileName; // Trả về tên file để lưu vào DB
            }
        }
        return null;
    }
}