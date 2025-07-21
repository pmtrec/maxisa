<?php

namespace PMT\SRC\SERVICE;
use PMT\SRC\REPOSITORY\CompteRepository;
use PMT\SRC\REPOSITORY\CreationRepository;

class CompteService{

    private  CompteRepository $repository;
    private  CreationRepository $creationCompte;


    public function __construct( ){
        $this->repository = new CompteRepository();
        $this->creationCompte = new CreationRepository();

    }

    public function getCompte ( $id){

        return $this->repository->SelectSoldeByUserId($id);  
    }
    
  public function addCompteSecondaire($userId, $numTelephone, $solde) {
    return $this->creationCompte->createCompteSecondaireByUserId($userId, $solde, $numTelephone);
}

  public function listerCompteSecondaire(int $userId, string $type): ?array {
    return $this->repository->SelectAllFromCompteWhereTypeSecondaire($userId, $type);
}
  public function listerNumberCompteSecondaire(int $userId, string $type): ?array {
    return $this->repository->SelectNumeroFromCompteWhereTypeSecondaire($userId, $type);
}



}
