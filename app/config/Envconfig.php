<?php
namespace PMT\App\Config;

use Dotenv\Dotenv;

class EnvConfig {
    private static bool $loaded = false;

    public static function load(): void {
        if (self::$loaded) return;

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        self::$loaded = true;
    }

    public static function database(): array {
        self::load();  
        // define('DB_DRIVER','$_ENV['DB_DRIVER']');

        return [
            'driver' => $_ENV['DB_DRIVER'] ?? '',
            'host'   => $_ENV['DB_HOST'] ?? '',
            'dbname' => $_ENV['DB_NAME'] ?? '',
            'user'   => $_ENV['DB_USER'] ?? '',
            'pass'   => $_ENV['DB_PASS'] ?? '',
            'port'   => $_ENV['DB_PORT'] ?? '',
        ];
    }
}
