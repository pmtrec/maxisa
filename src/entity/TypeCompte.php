<?php
namespace PMT\SRC\Entity;
enum TypeCompte :string {
    case Principal ='ComptePrincipal';
    case Secondaire = 'CompteSecondaire';
}