<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\SupabaseClient;
use PMT\SRC\Entity\UsersEntity;
use Exception;

class UserRepository {
    private SupabaseClient $supabase;

    public function __construct() {
        $this->supabase = SupabaseClient::getInstance();
    }

    /**
     * Authentification par téléphone et mot de passe
     */
    public function selectByTelephoneAndPassword(string $telephone, string $password): ?UsersEntity {
        try {
            // Rechercher l'utilisateur par téléphone
            $users = $this->supabase->select('users', [
                'telephone' => $telephone
            ]);

            if (empty($users)) {
                return null;
            }

            $userData = $users[0];

            // Vérifier le mot de passe
            if (!password_verify($password, $userData['password'])) {
                return null;
            }

            return UsersEntity::toObject($userData);

        } catch (Exception $e) {
            error_log("Erreur authentification: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function create(array $userData): ?UsersEntity {
        try {
            // Hasher le mot de passe
            if (isset($userData['password'])) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }

            // Définir le type par défaut si non spécifié
            if (!isset($userData['type_id'])) {
                $userData['type_id'] = 3; // client par défaut
            }

            $result = $this->supabase->insert('users', $userData);

            if (!empty($result)) {
                return UsersEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur création utilisateur: " . $e->getMessage());
            throw new Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }

    /**
     * Trouver un utilisateur par ID
     */
    public function findById(int $id): ?UsersEntity {
        try {
            $users = $this->supabase->select('users', [
                'id' => $id
            ]);

            if (!empty($users)) {
                return UsersEntity::toObject($users[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur recherche utilisateur: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Trouver un utilisateur par téléphone
     */
    public function findByTelephone(string $telephone): ?UsersEntity {
        try {
            $users = $this->supabase->select('users', [
                'telephone' => $telephone
            ]);

            if (!empty($users)) {
                return UsersEntity::toObject($users[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur recherche par téléphone: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(int $id, array $userData): ?UsersEntity {
        try {
            // Hasher le mot de passe si fourni
            if (isset($userData['password'])) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }

            $result = $this->supabase->update('users', $userData, [
                'id' => $id
            ]);

            if (!empty($result)) {
                return UsersEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur mise à jour utilisateur: " . $e->getMessage());
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function delete(int $id): bool {
        try {
            $this->supabase->delete('users', [
                'id' => $id
            ]);

            return true;
        } catch (Exception $e) {
            error_log("Erreur suppression utilisateur: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lister tous les utilisateurs avec pagination
     */
    public function findAll(int $limit = 50, int $offset = 0): array {
        try {
            $users = $this->supabase->select('users', [], ['*'], [
                'limit' => $limit,
                'offset' => $offset,
                'order' => 'created_at.desc'
            ]);

            $result = [];
            foreach ($users as $userData) {
                $result[] = UsersEntity::toObject($userData);
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erreur liste utilisateurs: " . $e->getMessage());
            return [];
        }
    }
}