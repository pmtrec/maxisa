<?php

namespace PMT\SRC\SERVICE;
use PMT\SRC\REPOSITORY\TransactionRepository;
use PMT\SRC\Entity\TransactionEntity;



class TransactionService {
    private TransactionRepository $transactionRepository;

    public function __construct(){
        $this->transactionRepository = new transactionRepository();
    }

    public function  getTran($id): ?array{
 
      return  $this->transactionRepository->SelectTransactionByCompte($id);
    }
    
}