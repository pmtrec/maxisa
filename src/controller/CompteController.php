<?php

namespace PMT\SRC\CONTROLLER;



use PMT\SRC\SERVICE\CompteService;
use PMT\APP\CORE\ABSTRACT\AbstractController;


class CompteController extends AbstractController {
    // protected string $layout = 'layout/connection.layout.php';
    
    private CompteService $compteService;
    
    
      public function __construct( ){
        parent::__construct();
        $this->compteService = new CompteService();
    }
    // public function getCompte(){
    //    $user=$this->session->get('user');
    //    $userId=$user->getId();
    // $compte=$this->compteService->obCompte($userId);
    //     if($compte){
    //         $this->session->set('compte',$compte);
    //         header('Location: /afficherTransaction');
    //     }   

    // }
      
    public function show() {
        //$this->renderHtml("home/transaction/transaction.php");
        $user=$this->session->get("user");
        
        $userId =$user->getId();
        
        $compte= $this->compteService->getCompte($userId) ;

        $this->session->set("compte", $compte);
       
        header("Location : /transaction");

        
 
    }

    public function index() {

    }

    public function create() {
        // Affiche un formulaire de création
       
    }

    public function store() {

    }

    public function edit() {}

    public function destroy() {
        // Supprime un utilisateur
    }
}
