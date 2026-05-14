<?php
class ContactModel {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function saveContact($fullname, $email, $phone, $subject, $message) {
        $sql = "INSERT INTO contacts (fullname, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $email, $phone, $subject, $message]);
    }
}