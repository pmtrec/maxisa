<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\SupabaseClient;
use PMT\SRC\Entity\CompteEntity;
use Exception;

class CreationRepository {
    private SupabaseClient $supabase;

    public function __construct() {
        $this->supabase = SupabaseClient::getInstance();
    }

    /**
     * Créer un compte secondaire pour un utilisateur
     */
    public function createCompteSecondaireByUserId(int $userId, float|string $solde = 0.0, string $numTelephone): ?CompteEntity {
        try {
            // Vérifier que l'utilisateur existe
            $users = $this->supabase->select('users', ['id' => $userId], ['id']);
            if (empty($users)) {
                throw new Exception("Utilisateur introuvable");
            }

            // Vérifier que le numéro de téléphone n'est pas déjà utilisé
            $existingCompte = $this->supabase->select('compte', [
                'num_telephone' => $numTelephone
            ], ['id']);

            if (!empty($existingCompte)) {
                throw new Exception("Ce numéro de téléphone est déjà associé à un compte");
            }

            // Génération d'un numéro de compte unique
            $numCompte = $this->generateUniqueNumCompte();

            $compteData = [
                'num_compte' => $numCompte,
                'num_telephone' => $numTelephone,
                'solde' => floatval($solde),
                'user_id' => $userId,
                'type_type_compte_enum' => 'secondaire'
            ];

            $result = $this->supabase->insert('compte', $compteData);

            if (!empty($result)) {
                // Créer une transaction initiale si le solde > 0
                if (floatval($solde) > 0) {
                    $this->createInitialTransaction($result[0]['id'], floatval($solde));
                }

                return CompteEntity::toObject($result[0]);
            }

            return null;

        } catch (Exception $e) {
            error_log("Erreur création compte secondaire : " . $e->getMessage());
            throw new Exception("Erreur lors de la création du compte secondaire : " . $e->getMessage());
        }
    }

    /**
     * Créer un compte principal pour un utilisateur
     */
    public function createComptePrincipalByUserId(int $userId, string $numTelephone, float $soldeInitial = 0.0): ?CompteEntity {
        try {
            // Vérifier qu'il n'y a pas déjà un compte principal
            $existingPrincipal = $this->supabase->select('compte', [
                'user_id' => $userId,
                'type_type_compte_enum' => 'principal'
            ], ['id']);

            if (!empty($existingPrincipal)) {
                throw new Exception("L'utilisateur a déjà un compte principal");
            }

            // Génération d'un numéro de compte unique
            $numCompte = $this->generateUniqueNumCompte();

            $compteData = [
                'num_compte' => $numCompte,
                'num_telephone' => $numTelephone,
                'solde' => $soldeInitial,
                'user_id' => $userId,
                'type_type_compte_enum' => 'principal'
            ];

            $result = $this->supabase->insert('compte', $compteData);

            if (!empty($result)) {
                // Créer une transaction initiale si le solde > 0
                if ($soldeInitial > 0) {
                    $this->createInitialTransaction($result[0]['id'], $soldeInitial);
                }

                return CompteEntity::toObject($result[0]);
            }

            return null;

        } catch (Exception $e) {
            error_log("Erreur création compte principal : " . $e->getMessage());
            throw new Exception("Erreur lors de la création du compte principal : " . $e->getMessage());
        }
    }

    /**
     * Créer une transaction initiale pour un nouveau compte
     */
    private function createInitialTransaction(int $compteId, float $montant): void {
        try {
            $transactionData = [
                'compte_id' => $compteId,
                'montant' => $montant,
                'type_type_transaction_enum' => 'depot',
                'description' => 'Dépôt initial lors de la création du compte',
                'date' => date('Y-m-d H:i:s')
            ];

            $this->supabase->insert('transactions', $transactionData);
        } catch (Exception $e) {
            error_log("Erreur création transaction initiale : " . $e->getMessage());
            // Ne pas faire échouer la création du compte pour cette erreur
        }
    }

    /**
     * Générer un numéro de compte unique
     */
    private function generateUniqueNumCompte(): string {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $generated = 'CPT-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            
            try {
                // Vérifier si le numéro existe déjà
                $existing = $this->supabase->select('compte', [
                    'num_compte' => $generated
                ], ['id']);

                $exists = !empty($existing);
                $attempts++;

                if ($attempts >= $maxAttempts) {
                    throw new Exception("Impossible de générer un numéro de compte unique après $maxAttempts tentatives");
                }

            } catch (Exception $e) {
                if (strpos($e->getMessage(), 'Impossible de générer') !== false) {
                    throw $e;
                }
                // En cas d'erreur de requête, on considère que le numéro n'existe pas
                $exists = false;
            }

        } while ($exists);

        return $generated;
    }

    /**
     * Valider les données d'un compte avant création
     */
    private function validateCompteData(array $data): bool {
        $required = ['user_id', 'num_telephone', 'type_type_compte_enum'];
        
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new Exception("Le champ $field est requis");
            }
        }

        // Valider le type de compte
        if (!in_array($data['type_type_compte_enum'], ['principal', 'secondaire'])) {
            throw new Exception("Type de compte invalide");
        }

        // Valider le format du numéro de téléphone
        if (!preg_match('/^[0-9+\-\s]+$/', $data['num_telephone'])) {
            throw new Exception("Format de numéro de téléphone invalide");
        }

        return true;
    }

    /**
     * Récupérer le nombre de comptes d'un utilisateur
     */
    public function countComptesByUserId(int $userId): array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId
            ], ['type_type_compte_enum']);

            $count = [
                'principal' => 0,
                'secondaire' => 0,
                'total' => count($comptes)
            ];

            foreach ($comptes as $compte) {
                $type = $compte['type_type_compte_enum'];
                if (isset($count[$type])) {
                    $count[$type]++;
                }
            }

            return $count;

        } catch (Exception $e) {
            error_log("Erreur comptage comptes : " . $e->getMessage());
            return ['principal' => 0, 'secondaire' => 0, 'total' => 0];
        }
    }
}