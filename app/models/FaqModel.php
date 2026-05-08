<?php
// app/models/FaqModel.php
class FaqModel {
    private $db;

    public function __construct() {
        // Giả sử bạn có file config kết nối database
        global $conn; 
        $this->db = $conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM faqs ORDER BY id DESC";
        return mysqli_query($this->db, $sql);
    }

    public function getWithPagination($limit, $offset) {
        $sql = "SELECT * FROM faqs ORDER BY id DESC LIMIT $limit OFFSET $offset"; 
        return mysqli_query($this->db, $sql);
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM faqs";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_assoc($result)['total'];
    }

    public function insert($question, $answer) {
        $sql = "INSERT INTO faqs (question, answer) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $question, $answer);
        return mysqli_stmt_execute($stmt);
    }

    public function update($id, $question, $answer) {
        $sql = "UPDATE faqs SET question = ?, answer = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $question, $answer, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function delete($id) {
        $sql = "DELETE FROM faqs WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }
}