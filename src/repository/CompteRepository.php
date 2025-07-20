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
      public function SelectAllFromCompteWhereTypeSecondaire(int $id,string $type):?CompteEntity{
        try {
              $sql = "SELECT * FROM compte WHERE user_id = :user_id type = :type ";
    $stmt = $pdo->prepare($sql);

    // Exécuter avec le paramètre sécurisé
    $stmt->execute([
        'type' => 'CompteSecondaire',
        'user_id' => $id

    ]);

    // Récupérer les résultats
    $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage pour test
    foreach ($comptes as $compte) {
        echo "Numéro de compte : " . $compte['num_compte'] . "<br>";
        echo "Solde : " . $compte['solde'] . "<br>";
        echo "<hr>";
    }
             }
      catch (\PDOException $e) {
            throw new \Exception("Recuperation compte compte".$e->getMessage());
        }

    }
}