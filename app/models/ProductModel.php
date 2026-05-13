<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); 
    }

    // =========================================================
    // 1. DÀNH CHO TRANG CHỦ & LOAD CƠ BẢN
    // =========================================================
    
    // Sản phẩm nổi bật
    public function getFeaturedProducts($limit = 8) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    ORDER BY p.sold_count DESC, p.id DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sản phẩm đang giảm giá (old_price > price)
    public function getSaleProducts($limit = 8) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    WHERE p.old_price > p.price 
                                    ORDER BY (p.old_price - p.price) DESC, p.id DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Sản phẩm mới nhất (Đề phòng HomeController gọi)
    public function getNewProducts($limit = 8) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    ORDER BY p.id DESC 
                                    LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ĐÃ FIX: Hàm lấy danh mục cho HomeController
    public function getCategories() {
        return $this->getAllCategories();
    }

    public function getCoreTechnologies() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT 6";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSolutions() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE c.slug = 'flue-gas-treatment' 
                LIMIT 6";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================
    // 2. DÀNH CHO TRANG SẢN PHẨM & TÌM KIẾM CỦA TECHZONE
    // =========================================================

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBrands() {
        return $this->db->query("SELECT DISTINCT brand FROM products ORDER BY brand ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts($keyword = '', $categoryId = '') {
        $sql = "SELECT COUNT(*) FROM products WHERE name LIKE :keyword";
        if (!empty($categoryId)) {
            $sql .= " AND category_id = :cat_id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        if (!empty($categoryId)) {
            $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getProductsPaginated($limit, $offset, $keyword = '', $categoryId = '', $brand = '', $minPrice = 0, $maxPrice = 999999999, $sort = 'newest') {
        $sql = "SELECT p.*, c.name as category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword AND p.price BETWEEN :min_price AND :max_price";
        
        if (!empty($categoryId)) $sql .= " AND p.category_id = :cat_id";
        if (!empty($brand)) $sql .= " AND p.brand = :brand";

        switch ($sort) {
            case 'price_asc': $sql .= " ORDER BY p.price ASC"; break;
            case 'price_desc': $sql .= " ORDER BY p.price DESC"; break;
            case 'popular': $sql .= " ORDER BY p.sold_count DESC"; break;
            case 'newest': $sql .= " ORDER BY p.created_at DESC"; break;
            default: $sql .= " ORDER BY p.id DESC";
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->bindValue(':min_price', $minPrice, PDO::PARAM_INT);
        $stmt->bindValue(':max_price', $maxPrice, PDO::PARAM_INT);
        if (!empty($categoryId)) $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        if (!empty($brand)) $stmt->bindValue(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts($catId, $excludeId, $limit = 4) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = :catId AND id != :exId LIMIT :limit");
        $stmt->bindValue(':catId', $catId, PDO::PARAM_INT);
        $stmt->bindValue(':exId', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================================================
    // 3. DÀNH CHO ADMIN (THÊM, SỬA, XÓA SẢN PHẨM)
    // =========================================================
    
    public function insertProduct($categoryId, $brand, $name, $price, $oldPrice, $thumbnail, $desc, $stock) {
        $stmt = $this->db->prepare("INSERT INTO products (category_id, brand, name, price, old_price, thumbnail, description, stock_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$categoryId, $brand, $name, $price, $oldPrice, $thumbnail, $desc, $stock]);
    }

    public function updateProduct($id, $categoryId, $brand, $name, $price, $oldPrice, $thumbnail, $desc, $stock) {
        if (!empty($thumbnail)) {
            $stmt = $this->db->prepare("UPDATE products SET category_id=?, brand=?, name=?, price=?, old_price=?, thumbnail=?, description=?, stock_count=? WHERE id=?");
            return $stmt->execute([$categoryId, $brand, $name, $price, $oldPrice, $thumbnail, $desc, $stock, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE products SET category_id=?, brand=?, name=?, price=?, old_price=?, description=?, stock_count=? WHERE id=?");
            return $stmt->execute([$categoryId, $brand, $name, $price, $oldPrice, $desc, $stock, $id]);
        }
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>