DROP DATABASE IF EXISTS cleantech;
CREATE DATABASE cleantech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cleantech;

SET FOREIGN_KEY_CHECKS = 0;

-- ==============================================
-- 1. TẠO BẢNG NGƯỜI DÙNG (USERS)
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

-- ==============================================
-- 2. TẠO BẢNG DANH MỤC (CATEGORIES)
-- ==============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- 3. TẠO BẢNG SẢN PHẨM (PRODUCTS) - Gộp 2 Web
-- ==============================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    efficiency VARCHAR(20),               -- Thuộc tính đặc thù của Cleantech
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    old_price DECIMAL(10,2) DEFAULT 0,    -- Thuộc tính đặc thù của TechZone
    installment_info VARCHAR(50),         -- Thông tin trả góp
    thumbnail VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- ==============================================
-- 4. TẠO BẢNG TIN TỨC (NEWS)
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
-- 5. BẢNG BÌNH LUẬN (COMMENTS) - Hỗ trợ cả 2 web
-- ==============================================
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NULL,                  -- Bỏ trống nếu là bình luận bài viết
    news_id INT NULL,                     -- Bỏ trống nếu là bình luận sản phẩm
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

CREATE TABLE IF NOT EXISTS page_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(50) NOT NULL UNIQUE, -- Định danh trang (vd: 'about')
    section_name VARCHAR(100) NOT NULL,    -- Tên phần (vd: 'tiểu sử')
    content_value TEXT NOT NULL,           -- Nội dung thực tế
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS faqs (
    f_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    question TEXT NOT NULL,
    answer TEXT,
    status ENUM('pending', 'answered') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- ==============================================
-- ĐỔ DỮ LIỆU MẪU ĐỂ TEST
-- ==============================================

-- 1. Tài khoản
INSERT INTO users (fullname, email, password, role, status, address) VALUES
('Quản trị viên', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, 'Hà Nội'),
('Khách hàng', 'user@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', 1, 'Hồ Chí Minh');

-- 2. Danh mục
INSERT INTO categories (name, slug) VALUES 
('Flue Gas Treatment', 'flue-gas-treatment'),
('Điện thoại', 'dien-thoai'), 
('Laptop', 'laptop');

-- 3. Sản phẩm (Gồm cả Cleantech và TechZone)
INSERT INTO products (category_id, name, description, efficiency, price, old_price, installment_info) VALUES
(1, 'Electrostatic Precipitation', 'High-efficiency particle removal.', '99.8%', 50000000, 55000000, NULL),
(1, 'Wet Scrubbing Systems', 'Liquid-based absorption technology.', '98.5%', 45000000, 48000000, NULL),
(2, 'iPhone 15 Pro Max 256GB', 'Siêu phẩm Apple 2023', NULL, 29990000, 34990000, 'Giảm 2 triệu'),
(3, 'MacBook Air M3', 'Laptop mỏng nhẹ, pin trâu', NULL, 27990000, 29990000, 'Tặng túi chống sốc');

-- 4. Tin tức & Bài viết
INSERT INTO news (title, badge, category, content, image) VALUES
('Global Energy Corp', '45% reduction', 'Power Generation', 'Implemented comprehensive flue gas treatment system across 3 coal-fired power plants.', 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b'),
('Maritime Solutions Ltd', 'IMO 2020 Compliance', 'Shipping', 'Deployed compact scrubber systems across fleet of 50 vessels.', 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3'),
('Apple ra mắt chip M3', 'Mới nhất', 'Công nghệ', 'Chip M3 mới của Apple mang lại hiệu năng vượt trội.', 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg');

-- 5. Bình luận (Test cả bình luận bài viết và bình luận sản phẩm)
INSERT INTO comments (user_id, news_id, product_id, content, rating) VALUES
(2, 1, NULL, 'Bài viết về năng lượng này phân tích rất chuyên sâu và dễ hiểu!', 5),
(2, NULL, 3, 'iPhone 15 Pro Max xài mượt, chụp hình siêu nét.', 5),
(2, 3, NULL, 'Cảm ơn admin đã cập nhật thông tin về chip M3 mới.', 4);

-- Chèn dữ liệu mẫu cho TechZone
INSERT INTO page_contents (page_key, section_name, content_value) VALUES 
('about_history', 'Tiểu sử & Hình thành', 'TechZone là hệ thống bán lẻ công nghệ hàng đầu...'),
('about_mission', 'Sứ mệnh & Tầm nhìn', 'Mang công nghệ đỉnh cao tới mọi nhà...'),
('about_goal', 'Mục tiêu chiến lược', 'Phủ sóng 34 tỉnh thành...');

INSERT INTO faqs (title, question, answer, status) VALUES 
('BẢO HÀNH', 'Chính sách bảo hành Laptop Gaming?', 'Bảo hành 12 tháng chính hãng.', 'answered'),
('TRẢ GÓP', 'Có hỗ trợ trả góp 0% không?', 'Có hỗ trợ qua thẻ tín dụng.', 'answered');
SET FOREIGN_KEY_CHECKS = 1;