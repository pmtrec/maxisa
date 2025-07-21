<?php

namespace PMT\SEEDERS;


use PDO;

class Seeder {
    public static function seed(PDO $pdo) {
        // Vider les tables dans l'ordre inverse des relations (transactions → compte → users → typeuser)
        $pdo->exec("TRUNCATE TABLE transactions, compte, users, typeuser RESTART IDENTITY CASCADE;");

        // Créer quelques types d’utilisateurs
        $pdo->exec("
            INSERT INTO typeuser (type_user_enum) VALUES 
            ('admin'), 
            ('caissier'), 
            ('client');
        ");

        // Générer les mots de passe hashés
        $pass1 = password_hash('pass1', PASSWORD_DEFAULT);
        $pass2 = password_hash('pass2', PASSWORD_DEFAULT);
        $pass3 = password_hash('pass3', PASSWORD_DEFAULT);

        // Ajouter des utilisateurs
        $pdo->exec("
            INSERT INTO users (nom, prenom, adresse, num_carte_identite, photorecto, photoverso, telephone, password, type_id) VALUES
            ('Ngom', 'Khouss', 'Dakar', 'CNI123456', 'recto1.jpg', 'verso1.jpg', '770000001', '$pass1', 3),
            ('Senghor', 'Fallou', 'Thies', 'CNI654321', 'recto2.jpg', 'verso2.jpg', '770000002', '$pass2', 3),
            ('Fall', 'Mame', 'Ziguinchor', 'CNI789012', 'recto3.jpg', 'verso3.jpg', '770000003', '$pass3', 2);
        ");

        // Ajouter des comptes
        $pdo->exec("
            INSERT INTO compte (num_compte, solde, user_id, type_type_compte_enum, num_telephone) VALUES
            ('CPT001', 10000.00, 1, 'principal', '770000001'),
            ('CPT002', 5000.00, 2, 'principal', '770000002'),
            ('CPT003', 0.00, 1, 'secondaire', '770000004'),
            ('CPT004', 0.00, 2, 'secondaire', '770000005');
        ");

        // Ajouter des transactions
        $pdo->exec("
            INSERT INTO transactions (date, compte_id, montant, type_type_transaction_enum) VALUES
            (CURRENT_DATE, 1, 2000.00, 'depot'),
            (CURRENT_DATE, 2, 1000.00, 'retrait');
        ");
    }
}
