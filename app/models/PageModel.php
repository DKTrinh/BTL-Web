<?php
// app/models/PageModel.php
class PageModel {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function getPageData($type) {
        $sql = "SELECT * FROM pages WHERE page_type = '$type' LIMIT 1";
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function updatePage($type, $content, $phone, $address, $image = null) {
        if ($image) {
            $sql = "UPDATE pages SET content = ?, phone = ?, address = ?, image_path = ? WHERE page_type = ?";
            $stmt = mysqli_prepare($this->db, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $content, $phone, $address, $image, $type);
        } else {
            $sql = "UPDATE pages SET content = ?, phone = ?, address = ? WHERE page_type = ?";
            $stmt = mysqli_prepare($this->db, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $content, $phone, $address, $type);
        }
        return mysqli_stmt_execute($stmt);
    }
}