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

    /**
     * Récupérer les transactions d'un compte
     */
    public function SelectTransactionByCompte(int $compteId): ?array {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId
            ], ['*'], [
                'order' => 'date.desc',
                'limit' => 50
            ]);

            if (empty($transactions)) {
                return [];
            }

            $result = [];
            foreach ($transactions as $transactionData) {
                $result[] = TransactionEntity::toObject($transactionData);
            }

            return $result;

        } catch (Exception $e) {
            error_log("Erreur récupération transactions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Créer une nouvelle transaction
     */
    public function create(array $transactionData): ?TransactionEntity {
        try {
            // S'assurer que la date est définie
            if (!isset($transactionData['date'])) {
                $transactionData['date'] = date('Y-m-d H:i:s');
            }

            $result = $this->supabase->insert('transactions', $transactionData);

            if (!empty($result)) {
                return TransactionEntity::toObject($result[0]);
            }

            return null;
        } catch (Exception $e) {
            error_log("Erreur création transaction: " . $e->getMessage());
            throw new Exception("Erreur lors de la création de la transaction : " . $e->getMessage());
        }
    }

    /**
     * Récupérer les transactions par période
     */
    public function getTransactionsByDateRange(int $compteId, string $dateDebut, string $dateFin): array {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId,
                'date' => ['operator' => 'gte', 'value' => $dateDebut]
            ], ['*'], [
                'order' => 'date.desc'
            ]);

            if (empty($transactions)) {
                return [];
            }

            // Filtrer côté PHP pour la date de fin
            $filteredTransactions = array_filter($transactions, function($transaction) use ($dateFin) {
                return strtotime($transaction['date']) <= strtotime($dateFin);
            });

            $result = [];
            foreach ($filteredTransactions as $transactionData) {
                $result[] = TransactionEntity::toObject($transactionData);
            }

            return $result;

        } catch (Exception $e) {
            error_log("Erreur récupération transactions par période: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupérer les transactions par type
     */
    public function getTransactionsByType(int $compteId, string $type): array {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId,
                'type_type_transaction_enum' => $type
            ], ['*'], [
                'order' => 'date.desc',
                'limit' => 100
            ]);

            $result = [];
            foreach ($transactions as $transactionData) {
                $result[] = TransactionEntity::toObject($transactionData);
            }

            return $result;

        } catch (Exception $e) {
            error_log("Erreur récupération transactions par type: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calculer le solde total des transactions
     */
    public function calculateBalance(int $compteId): float {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId
            ], ['montant', 'type_type_transaction_enum']);

            $balance = 0.0;
            foreach ($transactions as $transaction) {
                $montant = floatval($transaction['montant']);
                $type = $transaction['type_type_transaction_enum'];

                // Les dépôts ajoutent au solde, les retraits et transferts le diminuent
                if ($type === 'depot') {
                    $balance += $montant;
                } elseif (in_array($type, ['retrait', 'transfer', 'paiement'])) {
                    $balance -= $montant;
                }
            }

            return $balance;

        } catch (Exception $e) {
            error_log("Erreur calcul solde: " . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Récupérer les statistiques des transactions
     */
    public function getTransactionStats(int $compteId): array {
        try {
            $transactions = $this->supabase->select('transactions', [
                'compte_id' => $compteId
            ], ['montant', 'type_type_transaction_enum', 'date']);

            $stats = [
                'total_transactions' => count($transactions),
                'total_depot' => 0,
                'total_retrait' => 0,
                'total_transfer' => 0,
                'total_paiement' => 0,
                'derniere_transaction' => null
            ];

            $derniereDate = null;

            foreach ($transactions as $transaction) {
                $montant = floatval($transaction['montant']);
                $type = $transaction['type_type_transaction_enum'];
                $date = $transaction['date'];

                switch ($type) {
                    case 'depot':
                        $stats['total_depot'] += $montant;
                        break;
                    case 'retrait':
                        $stats['total_retrait'] += $montant;
                        break;
                    case 'transfer':
                        $stats['total_transfer'] += $montant;
                        break;
                    case 'paiement':
                        $stats['total_paiement'] += $montant;
                        break;
                }

                if ($derniereDate === null || strtotime($date) > strtotime($derniereDate)) {
                    $derniereDate = $date;
                    $stats['derniere_transaction'] = $transaction;
                }
            }

            return $stats;

        } catch (Exception $e) {
            error_log("Erreur statistiques transactions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Supprimer une transaction
     */
    public function delete(int $id): bool {
        try {
            $this->supabase->delete('transactions', [
                'id' => $id
            ]);

            return true;
        } catch (Exception $e) {
            error_log("Erreur suppression transaction: " . $e->getMessage());
            return false;
        }
    }
}