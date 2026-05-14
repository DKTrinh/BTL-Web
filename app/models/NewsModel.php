<?php
// Bổ sung dòng này để nạp lớp cha BaseModel, sửa lỗi Class Not Found
require_once __DIR__ . '/../core/BaseModel.php';

class NewsModel extends BaseModel {
    protected $table = 'news';

    // Lấy tất cả tin tức (mới nhất lên đầu)
    public function getAllNews() {
        $sql = "SELECT * FROM news ORDER BY created_at DESC";
        return $this->fetchAll($sql);
    }

    // Hàm getPublished() đóng vai trò như một bí danh (alias) của getAllNews()
    public function getPublished() {
        return $this->getAllNews();
    }

    // Lấy danh sách tin tức mới nhất cho trang chủ
    public function getLatestNews($limit = 3) {
        $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT " . (int)$limit;
        return $this->fetchAll($sql);
    }

    // Lấy tin tức theo ID
    public function getById($id) {
        $sql = "SELECT * FROM news WHERE id = ?";
        return $this->fetch($sql, [$id]);
    }

    // Tìm kiếm tin tức theo tiêu đề hoặc nội dung
    public function search($keyword) {
        $sql = "SELECT * FROM news WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC";
        return $this->fetchAll($sql, ["%$keyword%", "%$keyword%"]);
    }

    // Thêm tin tức mới
    public function create($data) {
        $sql = "INSERT INTO news (title, content, image, category, badge, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        return $this->execute($sql, [
            $data['title'], 
            $data['content'], 
            $data['image'], 
            $data['category'], 
            $data['badge']
        ]);
    }

    // Cập nhật tin tức
    public function update($id, $data) {
        $sql = "UPDATE news SET title = ?, content = ?, image = ?, category = ?, badge = ? WHERE id = ?";
        return $this->execute($sql, [
            $data['title'], 
            $data['content'], 
            $data['image'], 
            $data['category'], 
            $data['badge'], 
            $id
        ]);
    }

    // Xóa tin tức
    public function delete($id) {
        $sql = "DELETE FROM news WHERE id = ?";
        return $this->execute($sql, [$id]);
    }
}