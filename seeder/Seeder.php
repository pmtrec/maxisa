<?php
namespace Maxitsa\Seeder;

use PDO;

class Seeder {
    public static function seed(PDO $pdo) {
       
        $pdo->exec("TRUNCATE TABLE transaction, compte, personne RESTART IDENTITY CASCADE;");

      
        $pass1 = password_hash('pass1', PASSWORD_DEFAULT);
        $pass2 = password_hash('pass2', PASSWORD_DEFAULT);

        $pdo->exec("INSERT INTO personne (telephone, password, num_identite, photo_recto, photo_verso, prenom, nom, adresse, type_personne) VALUES
            ('770000001', '$pass1', '1244343455666', 'recto1.jpg', 'verso1.jpg', 'Khouss', 'Ngom', 'Dakar', 'client'),
            ('770000002', '$pass2', '1234899000999', 'recto2.jpg', 'verso2.jpg', 'Fallou', 'Senghor', 'Thies', 'client')");

     
        $pdo->exec("INSERT INTO compte (telephone, solde, personne_id, type_compte) VALUES
            ('770000001', 10000, 1, 'principal'),
            ('770000002', 5000, 2, 'principal'),
             ('770000003', 0, 1, 'secondaire'),
            ('770000004', 0, 2, 'secondaire');
            
            ");
            

     
        $pdo->exec("INSERT INTO transaction (compte_id, montant, date, type_transaction) VALUES
            (1, 2000, NOW(), 'depot'),
            (2, 1000, NOW(), 'retrait')");
    }
}