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
            throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
    }

    public function create(array $userData): ?UsersEntity {
        try {
            // Hasher le mot de passe
            if (isset($userData['password'])) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }

            $result = $this->supabase->insert('users', $userData);

            if (!empty($result)) {
                return UsersEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }

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
            throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        }
    }
}