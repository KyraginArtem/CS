<?php

class Database {
    private static string $host = "localhost";
    private static string $dbname = "cs_db";
    private static string $username = "root";
    private static string $password = "";
    private static $connection = null;

    // Получение соединения с БД
    public static function getConnection()
    {
        if (self::$connection === null)
        {
            try {
                self::$connection = new PDO(
                  "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                  self::$username,
                  self::$password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Ошибка подключения к БД: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
