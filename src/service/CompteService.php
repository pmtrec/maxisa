<?php

namespace PMT\SRC\SERVICE;
use PMT\SRC\REPOSITORY\CompteRepository;
class CompteService{

    private  CompteRepository $repository;

    public function __construct( ){
        $this->repository = new CompteRepository();
    }

    public function getCompte ( $id){

        return $this->repository->SelectSoldeByUserId($id);  
    }
}