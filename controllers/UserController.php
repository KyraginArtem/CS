<?php

require_once 'models/UserModel.php'; // Подключаем модель пользователя

class UserController {

    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); // Инициализируем модель
    }

    /**
     * GET /users/list
     * Получает список всех пользователей (только возраст и пол)
     */
    public function list(): void
    {
        $users = $this->userModel->getAllUsers();
        echo json_encode(["status" => "success", "data" => $users],
          JSON_PRETTY_PRINT);
    }

    /**
     * GET /users/get/{id}
     * Получает информацию о конкретном пользователе
     */
    public function getUser($id): void
    {
        $user = $this->userModel->getUserById($id);

        if ($user) {
            echo json_encode(["status" => "success", "data" => $user],
              JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Пользователь не найден"],
              JSON_PRETTY_PRINT);
        }
    }

    /**
     * PUT /users/update
     * Обновляет профиль текущего авторизованного пользователя
     */
    public function updateUser(): void
    {
        $inputData = json_decode(file_get_contents("php://input"),
          true);

        if (!isset($inputData['id']) || !isset($inputData['email']) ||
          !isset($inputData['password_hash']) || !isset($inputData['role']))
        {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Неверные входные данные"],
              JSON_PRETTY_PRINT);
            return;
        }

        $result = $this->userModel->updateUser($inputData['id'], $inputData['email'],
          $inputData['password_hash'], $inputData['role']);

        if ($result)
        {
            echo json_encode(["status" => "success", "message" => "Профиль обновлен"],
              JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Ошибка обновления профиля"],
              JSON_PRETTY_PRINT);
        }
    }
}
