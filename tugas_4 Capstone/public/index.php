<?php
session_start();

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/app/helpers.php';

spl_autoload_register(function (string $class): void {
    $prefixes = [
        'App\\' => BASE_PATH . '/app/',
        'Config\\' => BASE_PATH . '/config/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
            if (is_file($file)) {
                require $file;
            }
        }
    }
});

$database = new Config\Database();
$db = $database->getConnection();

$route = $_GET['route'] ?? 'home/index';
[$controllerKey, $action] = array_pad(explode('/', $route, 2), 2, 'index');

$controllers = [
    'home' => App\Controllers\HomeController::class,
    'pesanan' => App\Controllers\PesananController::class,
];

if (!isset($controllers[$controllerKey])) {
    http_response_code(404);
    echo 'Halaman tidak ditemukan.';
    exit();
}

$controllerClass = $controllers[$controllerKey];
$controller = new $controllerClass($db);

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Aksi tidak ditemukan.';
    exit();
}

$controller->{$action}();
