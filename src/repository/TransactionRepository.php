<?php

namespace PMT\SRC\REPOSITORY;

use PMT\APP\CORE\SupabaseClient;
use PMT\SRC\Entity\TransactionEntity;
use Exception;

class TransactionRepository {
    private SupabaseClient $supabase;

    public function __construct() {
        $this->supabase = SupabaseClient::getInstance();
    }

    public function SelectTransactionByCompte(int $compteId): ?array {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId
            ]);

            if (empty($transactions)) {
                return null;
            }

            $data = [];
            foreach ($transactions as $row) {
                $data[] = TransactionEntity::toObject($row);
            }

            // Trier par date décroissante (les plus récentes en premier)
            usort($data, function($a, $b) {
                return strtotime($b->getDate()) - strtotime($a->getDate());
            });

            // Limiter à 10 transactions
            return array_slice($data, 0, 10);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la sélection des transactions : " . $e->getMessage());
        }
    }

    public function create(array $transactionData): ?TransactionEntity {
        try {
            $result = $this->supabase->insert('transactions', $transactionData);

            if (!empty($result)) {
                return TransactionEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la transaction : " . $e->getMessage());
        }
    }

    public function getTransactionsByDateRange(int $compteId, string $dateDebut, string $dateFin): ?array {
        try {
            // Note: Pour les filtres de date complexes, vous pourriez avoir besoin d'utiliser des requêtes RPC
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId,
                'date' => ['operator' => 'gte', 'value' => $dateDebut]
            ]);

            if (empty($transactions)) {
                return null;
            }

            // Filtrer côté PHP pour la date de fin (ou créer une fonction RPC dans Supabase)
            $filteredTransactions = array_filter($transactions, function($transaction) use ($dateFin) {
                return strtotime($transaction['date']) <= strtotime($dateFin);
            });

            $data = [];
            foreach ($filteredTransactions as $row) {
                $data[] = TransactionEntity::toObject($row);
            }

            return $data;

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des transactions par période : " . $e->getMessage());
        }
    }
}