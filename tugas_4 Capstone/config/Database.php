<?php
namespace Config;

use mysqli;
use RuntimeException;

class Database
{
    private string $host;
    private string $user;
    private string $password;
    private string $database;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->user = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
        $this->database = getenv('DB_NAME') ?: 'wisata_haisyam';
    }

    public function getConnection(): mysqli
    {
        $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($connection->connect_error) {
            throw new RuntimeException('Koneksi database gagal: ' . $connection->connect_error);
        }

        $connection->set_charset('utf8mb4');
        return $connection;
    }
}
