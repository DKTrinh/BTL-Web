<?php
// app/models/FaqModel.php
class FaqModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Lấy FAQ đã trả lời cho Frontend
    public function getAnswered() {
        // Dùng PDO query thay vì mysqli_query
        $sql = "SELECT * FROM faqs WHERE status = 'answered' ORDER BY f_id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy dữ liệu cho Admin (có phân trang và lọc theo trạng thái)
    public function getWithPagination($limit, $offset, $status = null) {
        $where = $status ? "WHERE status = :status" : "";
        $sql = "SELECT * FROM faqs $where ORDER BY f_id DESC LIMIT :limit OFFSET :offset"; 
        
        $stmt = $this->db->prepare($sql);
        if ($status) $stmt->bindValue(':status', $status);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($status = null) {
        $where = $status ? "WHERE status = :status" : "";
        $sql = "SELECT COUNT(*) FROM faqs $where";
        
        $stmt = $this->db->prepare($sql);
        if ($status) $stmt->bindValue(':status', $status);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }

    public function getById($f_id) {
        $stmt = $this->db->prepare("SELECT * FROM faqs WHERE f_id = ?");
        $stmt->execute([$f_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // app/models/FaqModel.php
    public function insert($title, $question) {
        // Đảm bảo tên bảng là 'faqs' và các cột khớp với database
        $sql = "INSERT INTO faqs (title, question, status) VALUES (?, ?, 'pending')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $question]);
    }

    public function update($f_id, $title, $question, $answer, $status) {
        $sql = "UPDATE faqs SET title = ?, question = ?, answer = ?, status = ? WHERE f_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $question, $answer, $status, $f_id]);
    }

    public function delete($f_id) {
        $stmt = $this->db->prepare("DELETE FROM faqs WHERE f_id = ?");
        return $stmt->execute([$f_id]);
    }
}