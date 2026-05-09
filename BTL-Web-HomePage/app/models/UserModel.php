<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // --- AUTHENTICATION ---
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($fullname, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (fullname, email, password, role, status) VALUES (?, ?, ?, 'client', 1)");
        return $stmt->execute([$fullname, $email, $password]);
    }

    // --- ADMIN MANAGEMENT ---
    public function getUsers($limit, $offset) {
        $stmt = $this->db->prepare("SELECT id, fullname as username, email, role, status FROM users ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $fullname, $email, $role) {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([$fullname, $email, $role, $id]);
    }

    public function lockUser($id) {
        // Đảo trạng thái: 1 thành 0, 0 thành 1
        $stmt = $this->db->prepare("UPDATE users SET status = 1 - status WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function resetPassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $id]);
    }

    // --- USER PROFILE ---
    public function findByEmail($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $this->getUserByEmail($email);
    }

    public function updateProfile($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, gender = ?, birthdate = ?, bio = ? WHERE id = ?");
        return $stmt->execute([
            $data['full_name'], $data['email'], $data['phone'], 
            $data['gender'], $data['birthdate'], $data['bio'], $id
        ]);
    }

    public function getPasswordHash($id) {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public function updatePassword($id, $newHash) {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$newHash, $id]);
    }

    public function updateAvatar($id, $path) {
        $stmt = $this->db->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        return $stmt->execute([$path, $id]);
    }
    
}