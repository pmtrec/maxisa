<?php
namespace PMT\SRC\Entity;

enum TypeTransaction: string {
    case PAIEMENT = 'PAIEMENT';
    case TRANSERT = 'TRANSERT';
    case DEPOT = 'DEPOT';
    case RETRAIT = 'RETRAIT';
}
