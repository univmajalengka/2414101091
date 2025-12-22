<?php
namespace App\Controllers;

use mysqli;
use RuntimeException;

abstract class BaseController
{
    protected mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    protected function render(string $view, array $data = []): void
    {
        $viewPath = BASE_PATH . '/app/Views/' . $view . '.php';
        if (!is_file($viewPath)) {
            throw new RuntimeException('View tidak ditemukan: ' . $view);
        }

        extract($data);
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        include BASE_PATH . '/app/Views/layouts/main.php';
    }

    protected function redirect(string $route, array $params = []): void
    {
        $query = http_build_query(array_merge(['route' => $route], $params));
        header('Location: ?' . $query);
        exit();
    }
}
