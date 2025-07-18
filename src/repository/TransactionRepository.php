<?php
namespace PMT\SRC\REPOSITORY;
use PMT\APP\CORE\Database;
use PMT\SRC\Entity\CompteEntity;
use \PDO;
class TransactionRepository {
    
    private Database $db;

    public function __construct(){
        $this->db = Databass::getInstance()->getPDO();
    }

    public function SelectTransactionByCompte($id):?CompteEntity{
        try {
            $sql = "Select * from transactions where compte_id = :id";
                var_dump($sql);die;
             $stmt = $this->db->PDO->prepare($sql);
             $stmt->execute([":id"=>$id]);
             $result = fetch(PDO::FETCH_ASSOC);
         
             if($result){
                $compte = CompteEntity::toObject($result);
                return $compte;
             }
             return null;
        } catch (\PDOException $e) {
            throw new \Exception("".$e->getMessage());
        }

    }
}