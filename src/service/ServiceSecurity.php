<?php

namespace PMT\SRC\SERVICE;
use PMT\SRC\REPOSITORY\UserRepository;
use PMT\SRC\Entity\UsersEntity;



class ServiceSecurity {
    private UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function  login($phone, $password): ?UsersEntity {
 
      return  $this->userRepository->selectByTelephoneAndPassword($phone, $password);

         
    }
    
}