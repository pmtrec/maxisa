<?php
namespace PMT\SRC\Entity;

enum TypeTransaction: string {
    case Paiment = 'Paiement';
    case Transfert = 'Transfert';
    case Depot = 'Depot';
    case Retrait = 'Retrait';
}
