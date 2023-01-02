<?php
require './vendor/autoload.php';
require_once './api/post/authcontroller.php';
require_once './api/post/maincontroller.php';
header('Content-Type: application/json');
// include './config/auth.php';

// Define the routes
$routes = [
    'GET' => [
        '/' => ['Authentication', 'home'],
        '/view-books' => ['Maincontroller', 'viewBooks', 'checkJWT'],
    ],
    'POST' => [
        '/login' => ['Authentication', 'login'],
        '/register' => ['Authentication', 'register'],
        '/add-book' => ['Maincontroller', 'addBook', 'checkJWT'],
        '/delete-book' => ['Maincontroller', 'deleteBook', 'checkJWT'],
        '/update-title' => ['Maincontroller', 'updateBookTitle', 'checkJWT'],
        '/update-author' => ['Maincontroller', 'updateBookAuthor', 'checkJWT'],
    ]
];

// Get the request method and URI
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if the request method and URI match a defined route
if (isset($routes[$requestMethod][$requestUri])) {
    // Instantiate the controller
    list($controllerClass, $action) = $routes[$requestMethod][$requestUri];
    $controller = new $controllerClass();

    // Call the controller action
    $controller->$action();
} else {
    // 404 Not Found
    echo json_encode(
        array('message' => 'Method or Endpoint not found')
      );
}