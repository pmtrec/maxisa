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

}
