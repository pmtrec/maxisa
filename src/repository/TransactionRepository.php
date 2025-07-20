<?php
namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\Database;
use PMT\SRC\Entity\CompteEntity;
use PMT\SRC\Entity\TransactionEntity;
use PDO;

class TransactionRepository {
    
    private PDO $db; // Ici c'est bien un objet PDO

    public function __construct() {
        $this->db = Database::getInstance()->getPDO();
    }

    public function SelectTransactionByCompte($id): ?array {
        try {
            $sql = "SELECT * FROM transactions WHERE compte_id = :id ORDER BY date DESC LIMIT 10";

            $stmt = $this->db->prepare($sql);
            $data=[];
            $stmt->execute([":id" => 1]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[]=TransactionEntity::toObject($row);
            }
            // var_dump($data);
            // die(); 
            if ($data) {
                return $data;
            }
            return null;

        } catch (\PDOException $e) {

            throw new \Exception("Erreur lors de la sélection de la transaction : " . $e->getMessage());
        }
    }
}
