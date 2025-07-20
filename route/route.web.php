<?php
use PMT\SRC\CONTROLLER\UserController;
use PMT\SRC\CONTROLLER\SecurityController;
use PMT\SRC\CONTROLLER\CompteController;
use PMT\SRC\CONTROLLER\TransactionController;

return [
    'GET' => [
        '/'=> [SecurityController::class,'show'],
        '/home'=> [CompteController::class,'show'],
        '/transaction'=> [TransactionController::class,'getTransactions'],
        '/acceuil'=> [homeController::class,'show'],
        '/newcompte'=> [CompteController::class,'creationNewCompte'],
      

        // '/home'=> [UserController::class,'store'],
        // '/afficherSolde'=> [CompteController::class,'getCompte'],
        // '/afficherTransaction'=> [TransactionController::class,'getTransactions'],
    ],
    'POST'=> [
        '/login'=> [SecurityController::class,'login'],
          '/secondaire/store'=> [CompteController::class,'addNewCompte'],
    ]

];
