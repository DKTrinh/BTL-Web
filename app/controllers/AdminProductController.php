<?php
require_once '../app/models/ProductModel.php';

class AdminProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function index() {
        // Tái sử dụng hàm phân trang đã có sẵn ở ProductModel
        $limit = 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;
        
        $products = $this->productModel->getProductsPaginated($limit, $offset, '', '', '', 0, 999999999, 'newest');
        $total = $this->productModel->getTotalProducts();
        $totalPages = ceil($total / $limit);
        $categories = $this->productModel->getAllCategories();

        require_once '../app/views/layouts/header.php';
        require_once '../app/views/admin/products/index.php';
        require_once '../app/views/layouts/footer.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? 0);
            $oldPrice = trim($_POST['old_price'] ?? 0);
            $categoryId = $_POST['category_id'] ?? 1;
            $brand = trim($_POST['brand'] ?? 'OEM');
            $desc = trim($_POST['description'] ?? '');
            $stock = (int)($_POST['stock_count'] ?? 100);

            if (empty($name) || !is_numeric($price) || $price < 0) {
                $_SESSION['auth_status'] = 'error'; $_SESSION['auth_message'] = 'Dữ liệu không hợp lệ!';
                header("Location: public_entry.php?url=admin-products"); exit;
            }

            // Xử lý Upload Ảnh
            $thumbnailPath = 'https://via.placeholder.com/500x500?text=No+Image'; 
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . "/../../public/assets/uploads/products/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES["thumbnail"]["name"]));
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $fileName)) {
                    $thumbnailPath = 'assets/uploads/products/' . $fileName; 
                }
            }

            $this->productModel->insertProduct($categoryId, $brand, $name, $price, $oldPrice, $thumbnailPath, $desc, $stock);
            $_SESSION['auth_status'] = 'success'; $_SESSION['auth_message'] = 'Đã thêm sản phẩm!';
            header("Location: public_entry.php?url=admin-products"); exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? 0);
            $oldPrice = trim($_POST['old_price'] ?? 0);
            $categoryId = $_POST['category_id'] ?? 1;
            $brand = trim($_POST['brand'] ?? 'OEM');
            $desc = trim($_POST['description'] ?? '');
            $stock = (int)($_POST['stock_count'] ?? 100);

            $thumbnailPath = ''; 
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . "/../../public/assets/uploads/products/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES["thumbnail"]["name"]);
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $fileName)) {
                    $thumbnailPath = 'assets/uploads/products/' . $fileName; 
                }
            }

            $this->productModel->updateProduct($id, $categoryId, $brand, $name, $price, $oldPrice, $thumbnailPath, $desc, $stock);
            $_SESSION['auth_status'] = 'success'; $_SESSION['auth_message'] = 'Đã cập nhật sản phẩm!';
            header("Location: public_entry.php?url=admin-products"); exit;
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->productModel->deleteProduct($id);
            $_SESSION['auth_status'] = 'success'; $_SESSION['auth_message'] = 'Đã xóa sản phẩm!';
        }
        header("Location: public_entry.php?url=admin-products"); exit;
    }
}