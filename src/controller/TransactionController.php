<?php

namespace PMT\SRC\CONTROLLER;



use PMT\APP\CORE\ABSTRACT\AbstractController;

class TransactionController extends AbstractController {
    private TransactionService $transactionService;
     
      public function __construct( ){
        parent::__construct();
        
    }
    public function login() {
        $this->renderHtml("home/menu.php");
       
    }
    
    public function index() {
        // Affiche la liste des utilisateurs
     ;
    }

    public function create() {
        // Affiche un formulaire de création
       
    }

    public function store() {
        // Enregistre un nouvel utilisateur (POST)
        // Traitement des données ici
    }

    public function show() {
       
        
    }

    public function edit() {}

    public function destroy() {
        // Supprime un utilisateur
    }
    public function getTransactions() {
        $compte = $this->session->get("compte");
        $compte_id = $compte->getId();
        $this->transactionService->getTran( $compte_id );
        
         $this->renderHtml("home/transaction/transaction.php");
       

    }
}
