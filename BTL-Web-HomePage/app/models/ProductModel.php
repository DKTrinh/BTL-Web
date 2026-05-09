<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        // Giả định class Database::connect() của bạn đã cấu hình đúng vào DB 'cleantech'
        $this->db = Database::connect();
    }

    // ======================
    // LẤY TẤT CẢ SẢN PHẨM (KÈM TÊN DANH MỤC)
    // ======================
    public function getAll()
    {
        // JOIN với bảng categories để lấy tên danh mục ra view thay vì chỉ hiện ID
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ======================
    // FIX LỖI: CORE TECHNOLOGIES
    // ======================
    public function getCoreTechnologies()
    {
        // Lấy 6 sản phẩm/công nghệ mới nhất
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT 6";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ======================
    // SOLUTIONS
    // ======================
    public function getSolutions()
    {
        // Đã sửa lại: Query qua category_id hoặc JOIN qua bảng categories.
        // Ở đây mình lấy các giải pháp thuộc danh mục có slug là 'flue-gas-treatment' (theo dữ liệu mẫu đã insert trong file SQL)
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE c.slug = 'flue-gas-treatment' 
                LIMIT 6";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}