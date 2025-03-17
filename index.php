<?php


require_once 'autoload.php';

$urlList = [
  "/funds/" => [
    "GET" => ["FundsController", "listFunds"],
    "POST" => ["FundsController", "createFund"]
  ],
  "/users/" => [
    "GET" => ["UserController", "listUsers"],
    "POST" => ["UserController", "createUser"]
  ]
];


$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];


// Проверяем, есть ли такой маршрут в массиве
if (isset($urlList[$requestUri][$requestMethod])) {
    list($controllerName, $methodName) = $urlList[$requestUri][$requestMethod];

    // Создаем экземпляр контроллера и вызываем метод
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    http_response_code(404);
    echo "404 Not Found";
}