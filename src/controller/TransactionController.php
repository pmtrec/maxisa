<?php

namespace PMT\SRC\CONTROLLER;

use PMT\SRC\SERVICE\TransactionService;
use PMT\APP\CORE\ABSTRACT\AbstractController;

class TransactionController extends AbstractController {
    private TransactionService $transactionService;
     
    public function __construct() {
        parent::__construct();
        $this->transactionService = new TransactionService(); // Correction ici
    }

    public function login() {
        $this->renderHtml("home/menu.php");
    }

    public function index() {
        // Affiche la liste des transactions
    }

    public function create() {
        // Affiche un formulaire de création de transaction
    }

    public function store() {
        // Enregistre une nouvelle transaction
    }

    public function show() {
        // Détail d'une transaction
    }

    public function edit() {
        // Formulaire de modification
    }

    public function destroy() {
        // Supprime une transaction
    }

    public function getTransactions() {
        $mycompte = $this->session->get("compte");
        $compte_id = $mycompte->getId();
        $transactions = $this->transactionService->getTran($compte_id);
        // var_dump($transactions);die();
        if(count($transactions) > 0) {
            $this->session->set("transactions", $transactions);
            $this->renderHtml("home/transaction/transaction.php");
        }
      

        // $this->renderHtml("home/transaction/transaction.php");
    }
}
