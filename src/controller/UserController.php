<?php

namespace PMT\SRC\CONTROLLER;



use PMT\APP\CORE\ABSTRACT\AbstractController;

class UserController extends AbstractController {
    protected string $layout = 'connection.layout.php';
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
        // Affiche un utilisateur spécifique
        
    }

    public function edit() {}

    public function destroy() {
        // Supprime un utilisateur
    }
}
