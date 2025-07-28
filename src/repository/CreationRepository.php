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

    public function createCompteSecondaireByUserId(int $userId, float|string $solde = 0.0, string $numTelephone): ?CompteEntity {
        try {
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
                return CompteEntity::toObject($result[0]);
            }

            return null;

        } catch (Exception $e) {
            error_log("Erreur création compte secondaire : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Génère un numéro de compte unique
     */
    private function generateUniqueNumCompte(): string {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $generated = 'CPT-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
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
}