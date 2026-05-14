<?php
require_once __DIR__ . '/../core/BaseModel.php';

class CommentModel extends BaseModel {
    protected $table = 'comments';

    /**
     * Lấy danh sách bình luận của một bài viết cụ thể (hiển thị cho người dùng)
     */
    public function getCommentsByNewsId($news_id) {
        $sql = "SELECT c.*, u.fullname, u.avatar 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.news_id = ? 
                ORDER BY c.created_at DESC";
        return $this->fetchAll($sql, [$news_id]);
    }

    /**
     * Thêm bình luận mới
     */
    public function create($news_id, $user_id, $content) {
        $sql = "INSERT INTO comments (news_id, user_id, content, created_at) 
                VALUES (?, ?, ?, NOW())";
        return $this->execute($sql, [$news_id, $user_id, $content]);
    }

    /**
     * Lấy TẤT CẢ bình luận (Dành cho trang Quản trị Admin)
     * Hiển thị kèm tên người dùng và tiêu đề bài viết để dễ quản lý
     */
    public function getAllAdmin() {
        $sql = "SELECT c.*, u.fullname as user_name, n.title as news_title 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN news n ON c.news_id = n.id 
                ORDER BY c.created_at DESC";
        return $this->fetchAll($sql);
    }

    /**
     * Xóa một bình luận (Dành cho Admin khi phát hiện bình luận vi phạm)
     */
    public function delete($id) {
        $sql = "DELETE FROM comments WHERE id = ?";
        return $this->execute($sql, [$id]);
    }

    /**
     * Đếm tổng số bình luận (Dành cho Dashboard Admin)
     */
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM comments";
        $result = $this->fetch($sql);
        return $result['total'] ?? 0;
    }

    /**
     * Tìm kiếm bình luận theo nội dung (Bổ sung cho tính năng quản lý)
     */
    public function search($keyword) {
        $sql = "SELECT c.*, u.fullname as user_name, n.title as news_title 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN news n ON c.news_id = n.id 
                WHERE c.content LIKE ? 
                ORDER BY c.created_at DESC";
        return $this->fetchAll($sql, ["%$keyword%"]);
    }
}