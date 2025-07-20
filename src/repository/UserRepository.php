<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\Database;
use PMT\SRC\Entity\UsersEntity;
use PDO;
use Exception;

class UserRepository {
    private PDO $pdo;

    public function __construct() {
        // Utilisation du singleton et appel à getPDO()
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function selectByTelephoneAndPassword(string $telephone, string $password): ?UsersEntity {
        try {
            $sql = 'SELECT * FROM users WHERE telephone = :telephone AND password = :password';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':telephone' => $telephone,
                ':password' => $password
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return UsersEntity::toObject($result);
                
            }

            return null;
        } catch (\Throwable $th) {
            throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $th->getMessage());
        }
    }
}
