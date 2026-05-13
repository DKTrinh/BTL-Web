<?php

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=localhost;dbname=techzone;charset=utf8",
                    "root",
                    ""
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("DB Error: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    // ✅ FIX TOÀN BỘ MODEL (QUAN TRỌNG)
    public static function connect() {
        return self::getConnection();
    }
}