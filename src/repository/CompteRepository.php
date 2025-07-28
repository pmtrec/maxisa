<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\SupabaseClient;
use PMT\SRC\Entity\CompteEntity;
use Exception;

class CompteRepository {
    private SupabaseClient $supabase;

    public function __construct() {
        $this->supabase = SupabaseClient::getInstance();
    }

    /**
     * Récupérer le compte principal d'un utilisateur
     */
    public function SelectSoldeByUserId(int $id): ?CompteEntity {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $id,
                'type_type_compte_enum' => 'principal'
            ]);

            if (!empty($comptes)) {
                return CompteEntity::toObject($comptes[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur récupération compte principal: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer tous les comptes secondaires d'un utilisateur
     */
    public function SelectAllFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId,
                'type_type_compte_enum' => 'secondaire'
            ], ['*'], [
                'order' => 'created_at.desc'
            ]);

            if (!empty($comptes)) {
                $result = [];
                foreach ($comptes as $compteData) {
                    $result[] = CompteEntity::toObject($compteData);
                }
                return $result;
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur récupération comptes secondaires: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer les numéros de téléphone des comptes secondaires
     */
    public function SelectNumeroFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId,
                'type_type_compte_enum' => 'secondaire'
            ], ['num_telephone', 'id', 'num_compte'], [
                'order' => 'created_at.desc'
            ]);

            return !empty($comptes) ? $comptes : null;
        } catch (Exception $e) {
            error_log("Erreur récupération numéros comptes secondaires: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Créer un nouveau compte
     */
    public function create(array $compteData): ?CompteEntity {
        try {
            // Générer un numéro de compte unique si non fourni
            if (!isset($compteData['num_compte'])) {
                $compteData['num_compte'] = $this->generateUniqueNumCompte();
            }

            $result = $this->supabase->insert('compte', $compteData);

            if (!empty($result)) {
                return CompteEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur création compte: " . $e->getMessage());
            throw new Exception("Erreur lors de la création du compte : " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le solde d'un compte
     */
    public function updateSolde(int $compteId, float $nouveauSolde): bool {
        try {
            $result = $this->supabase->update('compte', [
                'solde' => $nouveauSolde
            ], [
                'id' => $compteId
            ]);

            return !empty($result);
        } catch (Exception $e) {
            error_log("Erreur mise à jour solde: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Trouver un compte par numéro de téléphone
     */
    public function findByNumTelephone(string $numTelephone): ?CompteEntity {
        try {
            $comptes = $this->supabase->select('compte', [
                'num_telephone' => $numTelephone
            ]);

            if (!empty($comptes)) {
                return CompteEntity::toObject($comptes[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur recherche par numéro: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Trouver un compte par ID
     */
    public function findById(int $id): ?CompteEntity {
        try {
            $comptes = $this->supabase->select('compte', [
                'id' => $id
            ]);

            if (!empty($comptes)) {
                return CompteEntity::toObject($comptes[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur recherche compte par ID: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer tous les comptes d'un utilisateur
     */
    public function findAllByUserId(int $userId): array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId
            ], ['*'], [
                'order' => 'type_type_compte_enum.asc,created_at.desc'
            ]);

            $result = [];
            foreach ($comptes as $compteData) {
                $result[] = CompteEntity::toObject($compteData);
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erreur récupération tous comptes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Générer un numéro de compte unique
     */
    private function generateUniqueNumCompte(): string {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $generated = 'CPT-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            
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