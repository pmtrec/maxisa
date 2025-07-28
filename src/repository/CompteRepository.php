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
            throw new Exception("Erreur lors de la récupération du compte : " . $e->getMessage());
        }
    }

    public function SelectAllFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId,
                'type_type_compte_enum' => strtolower($type)
            ]);

            return !empty($comptes) ? $comptes : null;
        } catch (Exception $e) {
            throw new Exception("Erreur récupération comptes secondaires : " . $e->getMessage());
        }
    }

    public function SelectNumeroFromCompteWhereTypeSecondaire(int $userId, string $type): ?array {
        try {
            $comptes = $this->supabase->select('compte', [
                'user_id' => $userId,
                'type_type_compte_enum' => strtolower($type)
            ], ['num_telephone']);

            return !empty($comptes) ? $comptes : null;
        } catch (Exception $e) {
            throw new Exception("Erreur récupération numéros comptes secondaires : " . $e->getMessage());
        }
    }

    public function create(array $compteData): ?CompteEntity {
        try {
            $result = $this->supabase->insert('compte', $compteData);

            if (!empty($result)) {
                return CompteEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création du compte : " . $e->getMessage());
        }
    }

    public function updateSolde(int $compteId, float $nouveauSolde): bool {
        try {
            $result = $this->supabase->update('compte', [
                'solde' => $nouveauSolde
            ], [
                'id' => $compteId
            ]);

            return !empty($result);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour du solde : " . $e->getMessage());
        }
    }
}