<?php
// app/controllers/AdminNewsController.php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/NewsModel.php';

class AdminNewsController extends BaseController {
    private $newsModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->newsModel = new NewsModel($this->db);
        
        // Kiểm tra quyền truy cập: Chỉ Admin mới được dùng
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            // Chuyển hướng nếu không phải admin
            $this->redirect('public_entry.php?url=login');
        }
    }

    // Hiển thị danh sách tin tức trong Dashboard
    public function index() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Admin hiển thị 10 bài/trang dạng bảng

        $newsList = $this->newsModel->getPublished($keyword, $page, $limit);
        $totalNews = $this->newsModel->countNews($keyword);
        $totalPages = ceil($totalNews / $limit);

        $this->render('admin/news/index', [
            'newsList'   => $newsList,
            'keyword'    => $keyword,
            'page'       => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Xử lý Thêm bài viết mới
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title    = trim($_POST['title']);
            $content  = trim($_POST['content']);
            $category = trim($_POST['category'] ?? 'Công nghệ');
            $badge    = trim($_POST['badge'] ?? '');
            
            // Xử lý ảnh (bạn có thể phát triển thêm tính năng upload file ở đây)
            $image = !empty($_POST['image']) ? trim($_POST['image']) : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b';

            if (!empty($title) && !empty($content)) {
                $this->newsModel->addNews($title, $content, $image, $category, $badge);
                $this->redirect('public_entry.php?url=admin/news');
            } else {
                $this->render('admin/news/create', ['error' => 'Vui lòng nhập đầy đủ Tiêu đề và Nội dung.']);
                return;
            }
        }
        $this->render('admin/news/create');
    }

    // Xóa bài viết
    public function delete() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) {
            $this->newsModel->deleteNews($id);
        }
        $this->redirect('public_entry.php?url=admin/news');
    }
}