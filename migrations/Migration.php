<?php 

namespace PMT\MIGRATIONS;


require_once dirname(__DIR__) . '/app/config/bootstrap.php';
require_once dirname(__DIR__) . '/app/config/env.php';

use PDO;

class Migration {
    public static function migrate(PDO $pdo) {
        $queries = [

            // Création de la table typeuser
            "CREATE TABLE IF NOT EXISTS typeuser (
                id SERIAL PRIMARY KEY,
                type_user_enum TEXT NOT NULL
            );",

            // Création de la table users
            "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100),
                adresse TEXT,
                num_carte_identite VARCHAR(50),
                photorecto TEXT,
                photoverso TEXT,
                telephone VARCHAR(20),
                password TEXT,
                type_id INTEGER,
                CONSTRAINT fk_users_typeuser FOREIGN KEY (type_id) REFERENCES typeuser(id)
            );",

            // Création de la table compte
            "CREATE TABLE IF NOT EXISTS compte (
                id SERIAL PRIMARY KEY,
                num_compte VARCHAR(50) NOT NULL UNIQUE,
                solde NUMERIC(15,2) DEFAULT 0.00,
                user_id INTEGER NOT NULL,
                type_type_compte_enum TEXT NOT NULL,
                num_telephone VARCHAR(20),
                CONSTRAINT fk_compte_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );",

            // Création de la table transactions
            "CREATE TABLE IF NOT EXISTS transactions (
                id SERIAL PRIMARY KEY,
                date DATE NOT NULL,
                compte_id INTEGER NOT NULL,
                montant NUMERIC(15,2) NOT NULL,
                type_type_transaction_enum TEXT,
                CONSTRAINT fk_transactions_compte FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            );"
        ];

        foreach ($queries as $query) {
            $pdo->exec($query);
        }
    }
}
