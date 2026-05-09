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
-- 3. TẠO BẢNG SẢN PHẨM (PRODUCTS)
-- ==============================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    efficiency VARCHAR(20),
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
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
    content TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==============================================
-- ĐỔ DỮ LIỆU MẪU ĐỂ TEST
-- ==============================================

-- Thêm 2 tài khoản test (Mật khẩu của cả 2 đều là: password)
-- Hash BCRYPT dưới đây là mã hóa chuẩn của chuỗi "password"
INSERT INTO users (fullname, email, password, role, status) VALUES
('Quản trị viên', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
('Khách hàng', 'user@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client', 1);

-- Thêm danh mục
INSERT INTO categories (name, slug) VALUES ('Flue Gas Treatment', 'flue-gas-treatment');

-- Thêm sản phẩm
INSERT INTO products (category_id, name, description, efficiency) VALUES
(1, 'Electrostatic Precipitation', 'High-efficiency particle removal using electrostatic forces to capture fine particulates.', '99.8%'),
(1, 'Wet Scrubbing Systems', 'Liquid-based absorption technology for removing acidic gases and soluble pollutants.', '98.5%'),
(1, 'Selective Catalytic Reduction', 'Advanced catalytic process for converting nitrogen oxides into harmless nitrogen and water vapor.', '95.0%'),
(1, 'Fabric Filtration', 'Baghouse technology using specialized filter media to capture particulate matter.', '99.9%');

-- Thêm bài viết
INSERT INTO news (title, badge, category, content, image) VALUES
('Global Energy Corp', '45% reduction in emissions', 'Power Generation', 'Implemented comprehensive flue gas treatment system across 3 coal-fired power plants.', 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b'),
('SteelTech Industries', '60% NOx reduction', 'Steel Manufacturing', 'Retrofitted existing facilities with SCR technology, dramatically improving air quality.', 'https://images.unsplash.com/photo-1581094288338-2314dddb7ece'),
('Maritime Solutions Ltd', 'IMO 2020 Compliance', 'Shipping', 'Deployed compact scrubber systems across fleet of 50 vessels, ensuring full regulatory compliance.', 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3');

SET FOREIGN_KEY_CHECKS = 1;