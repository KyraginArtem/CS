<?php

require_once 'database.php';

class UserModel {

    private ?PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Получение всех пользователей (только возраст и пол)
    public function getAllUsers(): bool|array
    {
        $stmt = $this->db->query("SELECT id, email, password_hash, role FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получение пользователя по ID
    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT id, email, password_hash, role FROM User WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Обновление профиля пользователя
    public function updateUser($id, $email, $password_hash, $role): bool
    {
        $stmt = $this->db->prepare("UPDATE User SET email = ?, password_hash = ?, role = ? WHERE id = ?");
        return $stmt->execute([$id, $email, $password_hash, $role]);
    }
}
