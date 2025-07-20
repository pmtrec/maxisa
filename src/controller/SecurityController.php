<?php

namespace PMT\SRC\CONTROLLER;



use PMT\APP\CORE\ABSTRACT\AbstractController;
use PMT\SRC\SERVICE\ServiceSecurity;

class SecurityController extends AbstractController {
    protected string $layout = 'layout/connection.layout.php';
    private ServiceSecurity $service;

    public function __construct( ){
         parent::__construct();
        $this->service = new ServiceSecurity();
    }
      
    public function show() {
        
        $this->renderHtml("connexion/connexion.php");
    //    require_once __DIR__ .'/../../template/connexion/connexion.php';
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

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            extract($_POST);
                //   var_dump($_POST);die;
  
            $user = $this->service->login($phone,$password);
       
         
            if ($user) {
                 
                $this->session->set("user", $user);
                header("Location: /home");
                // require_once __DIR__ ."/../../template/layout/base.layout.php";
                

            }else{
                     echo"mal";
            }
           



        }
        
    }

    public function edit() {}

    public function destroy() {
        // Supprime un utilisateur
    }
}
