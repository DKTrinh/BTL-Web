<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/NewsModel.php';
require_once __DIR__ . '/../models/CommentModel.php';

class NewsController extends BaseController {
    private $newsModel;
    private $commentModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->newsModel = new NewsModel($db);
        $this->commentModel = new CommentModel($db);
    }

    /**
     * Hiển thị danh sách tin tức (Trang News chính)
     * Hỗ trợ tính năng tìm kiếm theo từ khóa
     */
    public function index() {
        // Lấy từ khóa tìm kiếm từ thanh địa chỉ (nếu có)
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (!empty($keyword)) {
            // Nếu có từ khóa, gọi hàm tìm kiếm trong Model
            $newsList = $this->newsModel->search($keyword);
        } else {
            // Nếu không, lấy toàn bộ tin tức đã xuất bản
            $newsList = $this->newsModel->getPublished();
        }

        $this->render('pages/news', [
            'newsList' => $newsList,
            'keyword'  => $keyword,
            'title'    => 'Tin tức công nghệ - TechZone'
        ]);
    }

    /**
     * Hiển thị chi tiết một bài viết cụ thể
     * Thực hiện Nhiệm vụ 4: Trang đọc bài viết & Quản lý bình luận trên bài viết
     */
    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            header("Location: public_entry.php?url=news");
            exit;
        }

        // 1. Lấy nội dung bài viết
        $news = $this->newsModel->getById($id);

        if (!$news) {
            // Nếu không tìm thấy bài viết, quay lại trang tin tức
            header("Location: public_entry.php?url=news");
            exit;
        }

        // 2. Lấy danh sách bình luận đã được duyệt của bài viết này
        // (Sử dụng hàm getCommentsByNews trong CommentModel đã tạo)
        $comments = $this->commentModel->getCommentsByNews($id);

        $this->render('pages/news_detail', [
            'news'     => $news,
            'comments' => $comments,
            'title'    => $news['title']
        ]);
    }

    /**
     * Xử lý thêm bình luận mới từ người dùng
     */
    public function addComment() {
        // Chỉ cho phép gửi qua phương thức POST và phải đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                // Nếu chưa đăng nhập, thông báo hoặc chuyển hướng
                header("Location: public_entry.php?url=login");
                exit;
            }

            $news_id = isset($_POST['news_id']) ? (int)$_POST['news_id'] : 0;
            $user_id = $_SESSION['user_id'];
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';

            if ($news_id > 0 && !empty($content)) {
                // Lưu bình luận vào database
                $this->commentModel->addComment($news_id, $user_id, $content);
            }

            // Quay lại trang chi tiết bài viết sau khi bình luận
            header("Location: public_entry.php?url=news/detail&id=" . $news_id);
            exit;
        }
    }
}