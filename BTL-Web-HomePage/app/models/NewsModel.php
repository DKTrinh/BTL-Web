<?php
// app/models/NewsModel.php
require_once __DIR__ . '/../core/BaseModel.php';

class NewsModel extends BaseModel {
    protected $table = 'news';

    // 1. Dùng cho trang chủ (HomeController): Fix lỗi Fatal Error
    public function getSuccessStories($limit = 3) {
        $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT $limit";
        return $this->fetchAll($sql);
    }

    // 2. Dùng cho trang Tin tức: Lấy danh sách kèm phân trang và tìm kiếm
    public function getPublished($keyword = '', $page = 1, $limit = 6) {
        $page = max(1, (int)$page); // Đảm bảo trang luôn >= 1
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM news WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        return $this->fetchAll($sql, ["%$keyword%", "%$keyword%"]);
    }

    // 3. Đếm tổng số bài viết để tính số trang (Pagination)
    public function countNews($keyword = '') {
        $sql = "SELECT COUNT(*) as total FROM news WHERE title LIKE ? OR content LIKE ?";
        $result = $this->fetchOne($sql, ["%$keyword%", "%$keyword%"]);
        return $result['total'] ?? 0;
    }

    // 4. Lấy chi tiết 1 bài viết bằng ID
    public function getById($id) {
        $sql = "SELECT * FROM news WHERE id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // 5. (Dành cho Admin) Thêm bài viết mới
    public function addNews($title, $content, $image, $category = 'Công nghệ', $badge = '') {
        $sql = "INSERT INTO news (title, content, image, category, badge, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        return $this->execute($sql, [$title, $content, $image, $category, $badge]);
    }

    // 6. (Dành cho Admin) Cập nhật bài viết
    public function updateNews($id, $title, $content, $image, $category, $badge) {
        $sql = "UPDATE news SET title = ?, content = ?, image = ?, category = ?, badge = ?, updated_at = NOW() WHERE id = ?";
        return $this->execute($sql, [$title, $content, $image, $category, $badge, $id]);
    }

    // 7. (Dành cho Admin) Xóa bài viết
    public function deleteNews($id) {
        $sql = "DELETE FROM news WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}