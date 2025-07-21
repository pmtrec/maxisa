<?php 

namespace Maxitsa\Migrations;

require_once dirname(__DIR__) . '/app/config/bootstrap.php';
require_once dirname(__DIR__) . '/app/config/env.php';

require_once dirname(__DIR__) . '/app/config/bootstrap.php';
require_once dirname(__DIR__) . '/app/config/env.php';
use PDO;
class Migration {
    public static function migrate(PDO $pdo) {
        $queries = [
            
            "CREATE TABLE IF NOT EXISTS personne (
                id SERIAL PRIMARY KEY,
                telephone VARCHAR(20),
                password VARCHAR(255),
                num_identite VARCHAR(50),
                photo_recto TEXT,
                photo_verso TEXT,
                prenom VARCHAR(100),
                nom VARCHAR(100),
                adresse TEXT,
                type_personne VARCHAR(50)
            );",
            "CREATE TABLE IF NOT EXISTS compte (
                id SERIAL PRIMARY KEY,
                telephone VARCHAR(20),
                solde FLOAT,
                personne_id INTEGER,
                type_compte VARCHAR(50),
                FOREIGN KEY (personne_id) REFERENCES personne(id)
            );",
            "CREATE TABLE IF NOT EXISTS transaction (
                id SERIAL PRIMARY KEY,
                compte_id INTEGER,
                montant FLOAT,
                date TIMESTAMP,
                type VARCHAR(50),
                FOREIGN KEY (compte_id) REFERENCES compte(id)
            );",
            
            "DO $$ BEGIN IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_name='transaction' AND column_name='type_transaction') THEN ALTER TABLE transaction ADD COLUMN type_transaction VARCHAR(50); END IF; END $$;"
        ];
        foreach ($queries as $query) {
            $pdo->exec($query);
        }
    }
}
