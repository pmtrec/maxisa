<?php
namespace PMT\APP\CORE;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    private function __construct() {
        // Charger .env une seule fois
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2)); // remonte jusqu'à la racine
        $dotenv->safeLoad();

        $driver = $_ENV['DB_DRIVER'] ?? 'pgsql';
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $port = $_ENV['DB_PORT'] ?? '5432';
        $dbname = $_ENV['DB_NAME'] ?? 'khalil';
        $user = $_ENV['DB_USER'] ?? 'admin';
        $pass = $_ENV['DB_PASSWORD'] ?? 'admin123';

        $dsn = "$driver:host=$host;port=$port;dbname=$dbname";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }
}
