<?php

namespace PMT\SRC\CONTROLLER;

use PMT\SRC\SERVICE\CompteService;
use PMT\APP\CORE\ABSTRACT\AbstractController;
use Exception;


class CompteController extends AbstractController {
    private CompteService $compteService;
    
    public function __construct(){
        parent::__construct();
        $this->compteService = new CompteService();
    }
      
    public function show() {
        $user = $this->session->get("user");
        
        if (!$user) {
            header("Location: /");
            exit;
        }

        $userId = $user->getId();
        $compte = $this->compteService->getCompte($userId);
        
        if ($compte) {
            $this->session->set("compte", $compte);
            header("Location: /transaction");
        } else {
            // Créer un compte principal si aucun n'existe
            try {
                $compte = $this->compteService->createComptePrincipal(
                    $userId, 
                    $user->getTelephone(), 
                    0.0
                );
                $this->session->set("compte", $compte);
                header("Location: /transaction");
            } catch (Exception $e) {
                error_log("Erreur création compte principal: " . $e->getMessage());
                echo "Erreur lors de la création du compte";
            }
        }
    }

    public function creationNewCompte() {
        $user = $this->session->get("user");
        
        if (!$user) {
            header("Location: /");
            exit;
        }

        $userId = $user->getId();
        
        // Récupérer les comptes secondaires existants
        $comptesSecondaires = $this->compteService->listerCompteSecondaire($userId);
        $numberS = $this->compteService->listerNumberCompteSecondaire($userId);
        
        $this->session->set('comptesSecondaires', $comptesSecondaires);
        $this->session->set('numberS', $numberS);
        
        $this->renderHtml("home/compte/formulaireCreation.html.php", [
            'comptes' => $comptesSecondaires,
            'numeros' => $numberS
        ]);
    }

    public function addNewCompte() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $this->session->get("user");
            
            if (!$user) {
                header("Location: /");
                exit;
            }

            try {
                extract($_POST);
                $userId = $user->getId();

                // Validation des données
                if (empty($num_telephone)) {
                    throw new Exception("Le numéro de téléphone est requis");
                }

                $solde = floatval($solde ?? 0);

                // Créer le nouveau compte secondaire
                $nouveauCompte = $this->compteService->addCompteSecondaire($userId, $num_telephone, $solde);

                if ($nouveauCompte) {
                    // Récupérer la liste mise à jour
                    $comptesSecondaires = $this->compteService->listerCompteSecondaire($userId);
                    $numberS = $this->compteService->listerNumberCompteSecondaire($userId);
                    
                    $this->session->set('comptesSecondaires', $comptesSecondaires);
                    $this->session->set('numberS', $numberS);
                    
                    $this->renderHtml("home/compte/formulaireCreation.html.php", [
                        'comptes' => $comptesSecondaires,
                        'numeros' => $numberS,
                        'success' => 'Compte secondaire créé avec succès!'
                    ]);
                } else {
                    throw new Exception("Erreur lors de la création du compte");
                }
                
            } catch (Exception $e) {
                error_log("Erreur création compte: " . $e->getMessage());
                
                $comptesSecondaires = $this->compteService->listerCompteSecondaire($user->getId());
                $numberS = $this->compteService->listerNumberCompteSecondaire($user->getId());
                
                $this->renderHtml("home/compte/formulaireCreation.html.php", [
                    'comptes' => $comptesSecondaires,
                    'numeros' => $numberS,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    public function index() {
        // Liste des comptes
    }
    
    public function create() {
        // Formulaire de création
    }

    public function store() {
        // Enregistrer un compte
    }

    public function edit() {}

    public function destroy() {
        // Supprimer un compte
    }
}
