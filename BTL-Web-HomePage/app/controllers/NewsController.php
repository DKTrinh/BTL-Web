<?php
// app/controllers/NewsController.php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/NewsModel.php';

class NewsController extends BaseController {
    private $newsModel;

    public function __construct($db) {
        parent::__construct($db);
        $this->newsModel = new NewsModel($this->db);
    }

    // Trang chủ tin tức: Hiển thị danh sách, phân trang, tìm kiếm
    public function index() {
        // Lấy tham số từ URL
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 6; // Số bài viết trên 1 trang

        // Tính toán phân trang
        $totalNews = $this->newsModel->countNews($keyword);
        $totalPages = ceil($totalNews / $limit);
        
        // Lấy dữ liệu
        $newsList = $this->newsModel->getPublished($keyword, $page, $limit);

        // Ném dữ liệu ra View (sử dụng mảng data để bọc lại giống code cũ của bạn)
        $data = [
            'newsList'   => $newsList,
            'keyword'    => $keyword,
            'page'       => $page,
            'totalPages' => $totalPages,
            'totalNews'  => $totalNews
        ];

        // Do file BaseController có extract($data), ra view bạn có thể gọi $data['newsList'] hoặc $newsList đều được.
        $this->render('pages/news', ['data' => $data]);
    }

    // Xem chi tiết bài viết
    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            $this->redirect('public_entry.php?url=news');
        }

        $newsItem = $this->newsModel->getById($id);
        
        if (!$newsItem) {
            die("<h1 style='text-align:center; padding: 50px;'>Bài viết không tồn tại.</h1>");
        }

        // Cần tạo thêm file 'app/views/pages/news_detail.php' để hiển thị chi tiết
        $this->render('pages/news_detail', ['news' => $newsItem]); 
    }
}