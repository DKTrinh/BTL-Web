<?php
class UserModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // LƯU CẬP NHẬT PROFILE CHUẨN (Đã thêm email)
    public function updateProfile($id, $data) {
        // Kiểm tra xem email mới có bị trùng với người khác không
        $check = $this->db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $check->execute([$data['email'], $id]);
        if ($check->fetch()) { return false; } // Trùng email thì báo lỗi

        $stmt = $this->db->prepare("UPDATE users SET fullname=?, email=?, phone=?, address=?, gender=?, birthdate=? WHERE id=?");
        return $stmt->execute([
            $data['fullname'], $data['email'], $data['phone'], $data['address'], 
            $data['gender'], $data['birthdate'], $id
        ]);
    }

    public function updateAvatar($id, $path) {
        $stmt = $this->db->prepare("UPDATE users SET avatar=? WHERE id=?");
        return $stmt->execute([$path, $id]);
    }

    public function getPasswordHash($id) {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function updatePassword($id, $newHash) {
        $stmt = $this->db->prepare("UPDATE users SET password=? WHERE id=?");
        return $stmt->execute([$newHash, $id]);
    }

    // ==========================================
    // DÀNH CHO KHÁCH HÀNG TỰ ĐĂNG KÝ
    // ==========================================
    public function registerUser($fullname, $email, $password) {
    // $password ở đây đã được Controller băm sẵn rồi, KHÔNG băm thêm nữa!
    $sql = "INSERT INTO users (fullname, email, password, role, status) VALUES (?, ?, ?, 'client', 1)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$fullname, $email, $password]);
}

    // ==========================================
    // ADMIN: CÁC HÀM QUẢN TRỊ
    // ==========================================
    public function getUsers($limit, $offset) {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers() {
        return $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    // Cập nhật toàn bộ thông tin bởi Admin
    public function updateUser($id, $fullname, $email, $role, $phone, $address) {
        $stmt = $this->db->prepare("UPDATE users SET fullname=?, email=?, role=?, phone=?, address=? WHERE id=?");
        return $stmt->execute([$fullname, $email, $role, $phone, $address, $id]);
    }

    public function lockUser($id) {
        $stmt = $this->db->prepare("UPDATE users SET status = 1 - status WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function resetPassword($id, $pass) {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE users SET password=? WHERE id=?");
        return $stmt->execute([$hash, $id]);
    }

    public function createUser($fullname, $email, $password, $role) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (fullname, email, password, role, status) VALUES (?, ?, ?, ?, 1)");
        return $stmt->execute([$fullname, $email, $hash, $role]);
    }
}
?>