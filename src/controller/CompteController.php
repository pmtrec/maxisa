<?php

namespace PMT\SRC\CONTROLLER;



use PMT\SRC\SERVICE\CompteService;
use PMT\APP\CORE\ABSTRACT\AbstractController;


class CompteController extends AbstractController {
    // protected string $layout = 'layout/connection.layout.php';
    
    private CompteService $compteService;
    
    
      public function __construct(){
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
    $user = $this->session->get("user");
    
    

    // if (!$user) {
    //     header("Location: /login");
    //     exit;
    // }

    $userId = $user->getId();
    $compte = $this->compteService->getCompte($userId);
        

    $this->session->set("compte", $compte);

    header("Location: /transaction");
    //  $this->renderHtml("home/transaction/transaction.php");
   
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
    public function creationNewCompte() {
       $this->renderHtml("home/compte/formulaireCreation.html.php");
    }
  public function addNewCompte() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST);

        $user = $this->session->get("user");
        $userId = $user->getId();

        // Crée le nouveau compte secondaire
        $this->compteService->addCompteSecondaire($userId, $num_telephone, $solde, $num_compte);

        // Récupère tous les comptes secondaires de l'utilisateur
        $comptesSecondaires = $this->compteService->listerCompteSecondaire($userId, 'CompteSecondaire');
        $numberS=$this->compteService->listerNumberCompteSecondaire($userId, 'CompteSecondaire');
        $this->session->set('numberS', $numberS);

        var_dump($numberS);die();
    
        $this->renderHtml("home/compte/formulaireCreation.html.php", [
            'comptes' => $comptesSecondaires
        ]);
    }
}


}
