<?php
namespace PMT\SRC\REPOSITORY;
use PMT\APP\CORE\Database;
use PMT\SRC\Entity\CompteEntity;
use \PDO;

class CompteRepository {
    
     private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getPDO(); // ✅ ok, retourne un PDO
    }
    public function SelectSoldeByUserId(int $id):?CompteEntity{
        try {
              $sql = "SELECT * FROM compte WHERE user_id = ? AND type::text = ?";
              $stmt = $this->db->prepare($sql);
              $stmt->execute([$id, 'ComptePrincipal']);
              $result = $stmt->fetch(PDO::FETCH_ASSOC);
              if($result){
                $compte =CompteEntity::toObject($result);
                    // var_dump($compte);die;
                return $compte;
            
             }else{
                return null;
             }
        } catch (\PDOException $e) {
            throw new \Exception("Recuperation compte compte".$e->getMessage());
        }

    }
     public function SelectAllFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
    try {
        $sql = "SELECT * FROM compte WHERE user_id = :user_id AND type = :type";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'type' => $type
        ]);

        $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comptes ?: null;

    } catch (\PDOException $e) {
        throw new \Exception("Erreur récupération comptes secondaires : " . $e->getMessage());
    }
}

    public function SelectNumeroFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
    try {
        $sql = "SELECT num_telephone FROM compte WHERE user_id = :user_id AND type = :type";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'type' => $type
        ]);

        $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comptes ?: null;

    } catch (\PDOException $e) {
        throw new \Exception("Erreur récupération comptes secondaires : " . $e->getMessage());
    }
}


}