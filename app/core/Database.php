<?php
if (!class_exists('Database')) {
    class Database {
        public static function getConnection() {
            try {
                // ĐÃ ĐỒNG BỘ: Đổi dbname thành techzone cho đúng với database hiện tại
                $conn = new PDO(
                    "mysql:host=localhost;dbname=techzone;charset=utf8mb4",
                    "root",
                    ""
                );
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // =================================================================
                // TỰ ĐỘNG ĐỒNG BỘ TÀI KHOẢN MẪU THEO MÔI TRƯỜNG MÁY HIỆN TẠI
                // =================================================================
                try {
                    // 1. Tự động băm mật khẩu 123456 bằng chính PHP của máy đang chạy
                    $demoPasswordHash = password_hash('123456', PASSWORD_BCRYPT);

                    // 2. Kiểm tra xem bảng users đã tồn tại chưa (đề phòng chạy trước khi import SQL)
                    $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
                    if ($checkTable->rowCount() > 0) {
                        
                        // 3. Kiểm tra xem tài khoản mẫu đã tồn tại chưa
                        $stmt = $conn->prepare("SELECT id FROM users WHERE email = 'admin@gmail.com'");
                        $stmt->execute();
                        $adminExists = $stmt->fetch();

                        if (!$adminExists) {
                            // Nếu chưa có, tự động chèn mới tài khoản với chuỗi băm chuẩn của máy này
                            $conn->exec("INSERT INTO users (fullname, email, password, role, status, address, avatar) VALUES
                            ('Quản trị viên', 'admin@gmail.com', '{$demoPasswordHash}', 'admin', 1, 'Khu công nghệ cao', 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg')");
                            
                            $conn->exec("INSERT INTO users (fullname, email, password, role, status, address, avatar) VALUES
                            ('Khách hàng', 'user@gmail.com', '{$demoPasswordHash}', 'client', 1, 'Hồ Chí Minh', 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg')");
                        } else {
                            // Nếu đã có, ép cập nhật lại mật khẩu theo chuẩn mã hóa của máy này
                            $stmtUpdate = $conn->prepare("UPDATE users SET password = ? WHERE email IN ('admin@gmail.com', 'user@gmail.com')");
                            $stmtUpdate->execute([$demoPasswordHash]);
                        }
                    }
                } catch (PDOException $e_sync) {
                    // Nếu lỗi trong quá trình đồng bộ (ví dụ cấu trúc bảng chưa khớp), bỏ qua để không làm sập web
                }
                // =================================================================

                return $conn;
                
            } catch (PDOException $e) {
                die("DB Connection failed: " . $e->getMessage());
            }
        }
    }
}
?>