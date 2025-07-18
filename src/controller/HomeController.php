<?php

namespace PMT\SRC\CONTROLLER;



use PMT\APP\CORE\ABSTRACT\AbstractController;

class HomeController extends AbstractController {
     
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
        $this->renderHtml("home/transaction/transaction.php");
        
    }

    public function edit() {}

    public function destroy() {
        // Supprime un utilisateur
    }
}
