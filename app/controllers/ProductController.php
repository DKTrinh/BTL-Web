<?php
require_once '../app/models/ProductModel.php';

class ProductController {
    private $productModel;
    
    // Khởi tạo Model
    public function __construct() { 
        $this->productModel = new ProductModel(); 
    }

    public function index() {
        // 1. Nhận các tham số tìm kiếm và bộ lọc từ URL
        // Hỗ trợ cả 'q' (từ thanh tìm kiếm header) và 'keyword'
        $keyword = trim($_GET['q'] ?? ($_GET['keyword'] ?? '')); 
        $categoryId = $_GET['category'] ?? ''; 
        $brand = $_GET['brand'] ?? '';
        $maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 999999999;
        $sort = $_GET['sort'] ?? 'newest';
        
        // 2. Xử lý phân trang
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 12; // Hiển thị 12 sản phẩm 1 trang
        $offset = ($page - 1) * $limit;

        // 3. Gọi Model để lấy dữ liệu (Biến mấu chốt để không bị lỗi Undefined)
        $totalProducts = $this->productModel->getTotalProducts($keyword, $categoryId);
        $totalPages = ceil($totalProducts / $limit);
        
        // Lấy danh sách sản phẩm, danh mục và thương hiệu
        $products = $this->productModel->getProductsPaginated($limit, $offset, $keyword, $categoryId, $brand, 0, $maxPrice, $sort);
        $categories = $this->productModel->getAllCategories(); 
        $brands = $this->productModel->getAllBrands();

        // 4. Gọi View hiển thị và truyền biến sang
        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/products.php';
        require_once '../app/views/layouts/footer.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            header('Location: public_entry.php?url=products'); 
            exit;
        }
        
        // Lấy 4 sản phẩm gợi ý cùng danh mục
        $related = $this->productModel->getRelatedProducts($product['category_id'], $id, 4);

        require_once '../app/views/layouts/header.php';
        require_once '../app/views/pages/product_detail.php';
        require_once '../app/views/layouts/footer.php';
    }
}
?>