DROP DATABASE IF EXISTS techzone;
CREATE DATABASE techzone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techzone;

SET FOREIGN_KEY_CHECKS = 0;

-- ==============================================
-- 1. BẢNG NGƯỜI DÙNG (USERS)
-- ==============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    avatar VARCHAR(255),
    gender ENUM('male', 'female', 'other'),
    birthdate DATE,
    bio TEXT,
    role ENUM('admin','client') DEFAULT 'client',
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_email (email)
);

-- Đã chuyển TRUNCATE xuống đúng vị trí sau khi bảng đã được tạo thành công
TRUNCATE TABLE users;

-- ==============================================
-- 2. BẢNG DANH MỤC (CATEGORIES)
-- ==============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- 3. BẢNG SẢN PHẨM (PRODUCTS)
-- ==============================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    brand VARCHAR(50) DEFAULT 'OEM',
    name VARCHAR(255) NOT NULL,
    description TEXT,
    efficiency VARCHAR(20),
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    old_price DECIMAL(10,2) DEFAULT 0,
    installment_info VARCHAR(50),
    thumbnail VARCHAR(255),
    stock_count INT DEFAULT 100,
    sold_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- ==============================================
-- 4. BẢNG TIN TỨC (NEWS)
-- ==============================================
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    badge VARCHAR(50), 
    category VARCHAR(100), 
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- 5. BẢNG BÌNH LUẬN (COMMENTS)
-- ==============================================
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NULL,
    news_id INT NULL,
    content TEXT NOT NULL,
    rating INT DEFAULT 5,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_comment_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT fk_comment_news FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE
);

-- ==============================================
-- 6. BẢNG LIÊN HỆ (CONTACTS)
-- ==============================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('pending', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- 7. BẢNG ĐƠN HÀNG (ORDERS & ORDER_DETAILS)
-- ==============================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10,2) DEFAULT 0,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- ĐÃ SỬA: Đổi từ KEY thành FOREIGN KEY để đúng cú pháp MariaDB/MySQL
    CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_detail_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_order_detail_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ==============================================
-- ĐỔ DỮ LIỆU MẪU ĐỂ TEST GIAO DIỆN
-- ==============================================

-- Chuỗi hash dưới đây ứng với mật khẩu "123456" chuẩn Bcrypt
INSERT INTO users (fullname, email, password, role, status, address, avatar) VALUES
('Quản trị viên', 'admin@gmail.com', '$2y$10$89X77SgXGZp7wT8NqLwYGOZJ9bZJbE7D6i9XyE3G2h1p5Z8K9m2e.', 'admin', 1, 'Khu công nghệ cao', 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg'),
('Khách hàng', 'user@gmail.com', '$2y$10$89X77SgXGZp7wT8NqLwYGOZJ9bZJbE7D6i9XyE3G2h1p5Z8K9m2e.', 'client', 1, 'Hồ Chí Minh', 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg');

-- 2. Danh mục
INSERT INTO categories (name, slug) VALUES 
('Flue Gas Treatment', 'flue-gas-treatment'),
('Điện thoại', 'dien-thoai'), 
('Laptop', 'laptop');

-- 3. Sản phẩm
INSERT INTO products (category_id, brand, name, description, efficiency, price, old_price, installment_info, thumbnail, stock_count, sold_count) VALUES
(1, 'techzone', 'Electrostatic Precipitation', 'High-efficiency particle removal.', '99.8%', 50000000, 55000000, NULL, 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=500', 10, 2),
(1, 'techzone', 'Wet Scrubbing Systems', 'Liquid-based absorption technology.', '98.5%', 45000000, 48000000, NULL, 'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=500', 15, 5),
(2, 'Apple', 'iPhone 15 Pro Max 256GB', 'Siêu phẩm Apple vỏ Titan', NULL, 29990000, 34990000, 'Giảm 2 triệu', 'https://images.unsplash.com/photo-1696446701796-da61225697cc?w=500', 50, 120),
(2, 'Samsung', 'Samsung Galaxy S24 Ultra', 'Tích hợp AI siêu thông minh', NULL, 31000000, 33990000, 'Thu cũ đổi mới', 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=500', 30, 85),
(3, 'Apple', 'MacBook Air M3', 'Laptop mỏng nhẹ, pin trâu', NULL, 27990000, 29990000, 'Tặng túi chống sốc', 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=500', 40, 210),
(3, 'Dell', 'Dell XPS 15 9530', 'Laptop đồ hoạ viền siêu mỏng', NULL, 45000000, 48000000, 'Tặng chuột', 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500', 20, 45);

-- 4. Tin tức
INSERT INTO news (title, badge, category, content, image) VALUES
('Global Energy Corp', '45% reduction', 'Power Generation', 'Implemented comprehensive flue gas treatment system across 3 coal-fired power plants.', 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b'),
('Apple ra mắt chip M3', 'Mới nhất', 'Công nghệ', 'Chip M3 mới của Apple mang lại hiệu năng vượt trội.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8');

-- 5. Bình luận
INSERT INTO comments (user_id, news_id, product_id, content, rating) VALUES
(2, 1, NULL, 'Bài viết về năng lượng này phân tích rất chuyên sâu và dễ hiểu!', 5),
(2, NULL, 3, 'iPhone 15 Pro Max xài mượt, chụp hình siêu nét.', 5),
(2, 2, NULL, 'Cảm ơn admin đã cập nhật thông tin về chip M3 mới.', 4);

SET FOREIGN_KEY_CHECKS = 1;