<?php
require_once '../app/core/BaseModel.php';

class CommentModel extends BaseModel {
    // Phải khai báo đúng tên bảng trong database
    protected $table = 'comments'; 

    /**
     * Lấy bình luận đã được duyệt của bài viết
     */
    public function getByNewsId($newsId) {
        $sql = "SELECT comments.*, users.fullname 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE news_id = ? 
                ORDER BY created_at DESC";
        return $this->fetchAll($sql, [$newsId]);
    }
}