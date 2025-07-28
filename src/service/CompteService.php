<?php

namespace PMT\SRC\SERVICE;
use PMT\SRC\REPOSITORY\CompteRepository;
use PMT\SRC\REPOSITORY\CreationRepository;
use Exception;

class CompteService{

    private  CompteRepository $repository;
    private  CreationRepository $creationCompte;

    public function __construct( ){
        $this->repository = new CompteRepository();
        $this->creationCompte = new CreationRepository();
    }

    /**
     * Récupérer le compte principal d'un utilisateur
     */
    public function getCompte($id){
        return $this->repository->SelectSoldeByUserId($id);  
    }
    
    /**
     * Ajouter un compte secondaire
     */
    public function addCompteSecondaire($userId, $numTelephone, $solde = 0.0) {
        try {
            return $this->creationCompte->createCompteSecondaireByUserId($userId, $solde, $numTelephone);
        } catch (Exception $e) {
            error_log("Erreur service création compte secondaire: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lister les comptes secondaires d'un utilisateur
     */
    public function listerCompteSecondaire(int $userId, string $type = 'secondaire'): ?array {
        return $this->repository->SelectAllFromCompteWhereTypeSecondaire($userId, $type);
    }

    /**
     * Lister les numéros des comptes secondaires
     */
    public function listerNumberCompteSecondaire(int $userId, string $type = 'secondaire'): ?array {
        return $this->repository->SelectNumeroFromCompteWhereTypeSecondaire($userId, $type);
    }

    /**
     * Récupérer tous les comptes d'un utilisateur
     */
    public function getAllComptesByUserId(int $userId): array {
        return $this->repository->findAllByUserId($userId);
    }

    /**
     * Mettre à jour le solde d'un compte
     */
    public function updateSolde(int $compteId, float $nouveauSolde): bool {
        return $this->repository->updateSolde($compteId, $nouveauSolde);
    }

    /**
     * Trouver un compte par numéro de téléphone
     */
    public function findCompteByNumTelephone(string $numTelephone) {
        return $this->repository->findByNumTelephone($numTelephone);
    }

    /**
     * Créer un compte principal pour un nouvel utilisateur
     */
    public function createComptePrincipal(int $userId, string $numTelephone, float $soldeInitial = 0.0) {
        try {
            return $this->creationCompte->createComptePrincipalByUserId($userId, $numTelephone, $soldeInitial);
        } catch (Exception $e) {
            error_log("Erreur service création compte principal: " . $e->getMessage());
            throw $e;
        }
    }
}
