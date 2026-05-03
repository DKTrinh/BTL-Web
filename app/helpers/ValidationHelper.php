<?php
class ValidationHelper {
    public static function clean($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePassword($password) {
        // Tối thiểu 6 ký tự
        return strlen($password) >= 6;
    }
}