<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PMT\APP\CORE\SupabaseClient;

try {
    echo "🌱 Seeding des données Supabase...\n";
    
    $supabase = SupabaseClient::getInstance();
    
    // Vérifier que les types d'utilisateurs existent
    $types = $supabase->select('typeuser');
    if (empty($types)) {
        echo "📝 Création des types d'utilisateurs...\n";
        $supabase->insert('typeuser', ['type_user_enum' => 'admin']);
        $supabase->insert('typeuser', ['type_user_enum' => 'caissier']);
        $supabase->insert('typeuser', ['type_user_enum' => 'client']);
    }
    
    // Créer des utilisateurs de test
    echo "👥 Création des utilisateurs de test...\n";
    
    $users = [
        [
            'nom' => 'Ngom',
            'prenom' => 'Khouss',
            'adresse' => 'Dakar',
            'num_carte_identite' => 'CNI123456',
            'photorecto' => 'recto1.jpg',
            'photoverso' => 'verso1.jpg',
            'telephone' => '770000001',
            'password' => password_hash('pass1', PASSWORD_DEFAULT),
            'type_id' => 3
        ],
        [
            'nom' => 'Senghor',
            'prenom' => 'Fallou',
            'adresse' => 'Thies',
            'num_carte_identite' => 'CNI654321',
            'photorecto' => 'recto2.jpg',
            'photoverso' => 'verso2.jpg',
            'telephone' => '770000002',
            'password' => password_hash('pass2', PASSWORD_DEFAULT),
            'type_id' => 3
        ],
        [
            'nom' => 'Fall',
            'prenom' => 'Mame',
            'adresse' => 'Ziguinchor',
            'num_carte_identite' => 'CNI789012',
            'photorecto' => 'recto3.jpg',
            'photoverso' => 'verso3.jpg',
            'telephone' => '770000003',
            'password' => password_hash('pass3', PASSWORD_DEFAULT),
            'type_id' => 2
        ]
    ];
    
    $createdUsers = [];
    foreach ($users as $userData) {
        try {
            // Vérifier si l'utilisateur existe déjà
            $existing = $supabase->select('users', ['telephone' => $userData['telephone']], ['id']);
            if (empty($existing)) {
                $result = $supabase->insert('users', $userData);
                if (!empty($result)) {
                    $createdUsers[] = $result[0];
                    echo "   ✅ Utilisateur créé: " . $userData['nom'] . " " . $userData['prenom'] . "\n";
                }
            } else {
                echo "   ⚠️  Utilisateur existe déjà: " . $userData['nom'] . " " . $userData['prenom'] . "\n";
                $createdUsers[] = $existing[0];
            }
        } catch (Exception $e) {
            echo "   ❌ Erreur création utilisateur " . $userData['nom'] . ": " . $e->getMessage() . "\n";
        }
    }
    
    // Créer des comptes
    echo "💳 Création des comptes...\n";
    
    $comptes = [
        [
            'num_compte' => 'CPT-2025-001001',
            'solde' => 10000.00,
            'user_id' => $createdUsers[0]['id'] ?? 1,
            'type_type_compte_enum' => 'principal',
            'num_telephone' => '770000001'
        ],
        [
            'num_compte' => 'CPT-2025-002001',
            'solde' => 5000.00,
            'user_id' => $createdUsers[1]['id'] ?? 2,
            'type_type_compte_enum' => 'principal',
            'num_telephone' => '770000002'
        ],
        [
            'num_compte' => 'CPT-2025-001002',
            'solde' => 0.00,
            'user_id' => $createdUsers[0]['id'] ?? 1,
            'type_type_compte_enum' => 'secondaire',
            'num_telephone' => '770000004'
        ]
    ];
    
    $createdComptes = [];
    foreach ($comptes as $compteData) {
        try {
            // Vérifier si le compte existe déjà
            $existing = $supabase->select('compte', ['num_compte' => $compteData['num_compte']], ['id']);
            if (empty($existing)) {
                $result = $supabase->insert('compte', $compteData);
                if (!empty($result)) {
                    $createdComptes[] = $result[0];
                    echo "   ✅ Compte créé: " . $compteData['num_compte'] . " (Solde: " . $compteData['solde'] . ")\n";
                }
            } else {
                echo "   ⚠️  Compte existe déjà: " . $compteData['num_compte'] . "\n";
                $createdComptes[] = $existing[0];
            }
        } catch (Exception $e) {
            echo "   ❌ Erreur création compte " . $compteData['num_compte'] . ": " . $e->getMessage() . "\n";
        }
    }
    
    // Créer des transactions
    echo "💸 Création des transactions...\n";
    
    $transactions = [
        [
            'compte_id' => $createdComptes[0]['id'] ?? 1,
            'montant' => 2000.00,
            'type_type_transaction_enum' => 'depot',
            'description' => 'Dépôt initial'
        ],
        [
            'compte_id' => $createdComptes[1]['id'] ?? 2,
            'montant' => 1000.00,
            'type_type_transaction_enum' => 'retrait',
            'description' => 'Retrait ATM'
        ]
    ];
    
    foreach ($transactions as $transactionData) {
        try {
            $result = $supabase->insert('transactions', $transactionData);
            if (!empty($result)) {
                echo "   ✅ Transaction créée: " . $transactionData['type_type_transaction_enum'] . " de " . $transactionData['montant'] . " FCFA\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Erreur création transaction: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n🎉 Seeding terminé avec succès!\n";
    echo "Vous pouvez maintenant tester l'application avec:\n";
    echo "   - Téléphone: 770000001, Mot de passe: pass1\n";
    echo "   - Téléphone: 770000002, Mot de passe: pass2\n";
    echo "   - Téléphone: 770000003, Mot de passe: pass3\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors du seeding: " . $e->getMessage() . "\n";
}