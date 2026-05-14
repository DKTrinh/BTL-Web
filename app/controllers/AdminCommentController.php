<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/CommentModel.php';

class AdminCommentController extends BaseController {
    private $commentModel;

    public function __construct($db) {
        parent::__construct($db);
        // Kiểm tra quyền Admin trước khi cho phép truy cập
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: public_entry.php?url=login');
            exit();
        }
        $this->commentModel = new CommentModel($this->db);
    }

    /**
     * Hiển thị danh sách toàn bộ bình luận
     */
    public function index() {
        // Kiểm tra nếu có từ khóa tìm kiếm
        $keyword = $_GET['search'] ?? '';
        
        if (!empty($keyword)) {
            $comments = $this->commentModel->search($keyword);
        } else {
            $comments = $this->commentModel->getAllAdmin();
        }

        // Truyền dữ liệu sang view admin/comments/index.php
        $this->render('admin/comments/index', [
            'comments' => $comments,
            'keyword' => $keyword
        ]);
    }

    /**
     * Xóa bình luận
     */
    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $result = $this->commentModel->delete($id);
            if ($result) {
                $_SESSION['success'] = "Xóa bình luận thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa bình luận.";
            }
        }

        // Quay lại trang danh sách bình luận
        header('Location: public_entry.php?url=admin/comments');
        exit();
    }
}