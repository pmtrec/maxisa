<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PMT\APP\CORE\SupabaseClient;

try {
    echo "🔄 Test de connexion à Supabase...\n";
    
    $supabase = SupabaseClient::getInstance();
    
    // Test de connexion
    if ($supabase->testConnection()) {
        echo "✅ Connexion à Supabase réussie!\n";
        
        // Test de lecture des types d'utilisateurs
        $types = $supabase->select('typeuser');
        echo "📋 Types d'utilisateurs trouvés: " . count($types) . "\n";
        
        foreach ($types as $type) {
            echo "   - " . $type['type_user_enum'] . "\n";
        }
        
        // Test de lecture des utilisateurs
        $users = $supabase->select('users', [], ['id', 'nom', 'prenom', 'telephone'], ['limit' => 5]);
        echo "👥 Utilisateurs trouvés: " . count($users) . "\n";
        
        foreach ($users as $user) {
            echo "   - " . $user['nom'] . " " . ($user['prenom'] ?? '') . " (" . $user['telephone'] . ")\n";
        }
        
    } else {
        echo "❌ Échec de la connexion à Supabase\n";
        echo "Vérifiez votre configuration dans le fichier .env\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Vérifiez votre configuration Supabase dans le fichier .env\n";
}