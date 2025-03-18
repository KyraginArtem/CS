<?php

require_once 'autoload.php';

$urlList = [
  "/funds/" => [
    "GET" => ["FundsController", "listFunds"],
    "POST" => ["FundsController", "createFund"]
  ],
  "/users/list" => [
    "GET" => ["UserController", "list"]
  ],
  "/users/get" => [
    "GET" => ["UserController", "getUser"]
  ],
  "/users/update" => [
    "PUT" => ["UserController", "updateUser"]
  ]
];

$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Проверяем, есть ли такой маршрут в массиве
if (isset($urlList[$requestUri][$requestMethod])) {
    list($controllerName, $methodName) = $urlList[$requestUri][$requestMethod];

    // Создаем экземпляр контроллера и вызываем метод
    $controller = new $controllerName();

    // Если эндпоинт /users/get/{id}, извлекаем ID из запроса
    if ($requestUri === "/users/get" && isset($_GET['id'])) {
        $controller->$methodName($_GET['id']);
    } else {
        $controller->$methodName();
    }
} else {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Эндпоинт не найден"]);
}
