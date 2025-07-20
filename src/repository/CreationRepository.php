<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\Database;
use PMT\SRC\Entity\CompteEntity;
use \PDO;

class CreationRepository {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getPDO(); // Connexion PDO OK
    }

    public function createCompteSecondaireByUserId(int $userId, float|string $solde = 0.0, string $numTelephone): ?CompteEntity {
        try {
            // Génération d’un numéro de compte unique automatiquement
            $numCompte = $this->generateUniqueNumCompte();

            $sql = "INSERT INTO compte (num_compte, num_telephone, solde, user_id, type)
                    VALUES (:num_compte, :num_telephone, :solde, :user_id, :type)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':num_compte'     => $numCompte,
                ':num_telephone'  => $numTelephone,
                ':solde'          => floatval($solde),
                ':user_id'        => $userId,
                ':type'           => 'CompteSecondaire',
            ]);

            // Récupérer le dernier ID inséré
            $lastId = $this->db->lastInsertId();

            // Sélectionner l’objet inséré
            $stmtSelect = $this->db->prepare("SELECT * FROM compte WHERE id = :id");
            $stmtSelect->execute([':id' => $lastId]);
            $data = $stmtSelect->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return CompteEntity::toObject($data);
            }

            return null;

        } catch (\PDOException $e) {
            error_log("Erreur création compte secondaire : " . $e->getMessage());
            return null;
        }
    }

    // Génère un numéro de compte unique
    private function generateUniqueNumCompte(): string {
        do {
            $generated = 'CPT-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM compte WHERE num_compte = :num");
            $stmt->execute([':num' => $generated]);
            $count = $stmt->fetchColumn();

        } while ($count > 0);

        return $generated;
    }
}
