<?php

namespace PMT\SRC\Entity;

use PMT\APP\CORE\ABSTRACT\AbstractEntity;

class TransactionEntity extends AbstractEntity {
    private int $id;
    private string $date;
    private string $typetransaction; // Changé pour string au lieu d'enum
    private float $montant;

    public function __construct(
        int $id = 0,
        string $date = "",
        string $typetransaction = "depot",
        float $montant = 0.0
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->typetransaction = $typetransaction;
        $this->montant = $montant;
    }

    public static function toArray(): array {
        return [
            "id" => $this->id,
            "date" => $this->date,
            "montant" => $this->montant,
            "typetransaction" => $this->typetransaction
        ];
    }

    public static function toObject($data): static {
        return new static(
            $data['id'] ?? 0,
            $data['date'] ?? '',
            $data['type_type_transaction_enum'] ?? 'depot',
            floatval($data['montant'] ?? 0.0)
        );
    }

    // === GETTERS & SETTERS ===

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): self {
        $this->date = $date;
        return $this;
    }

    public function getTypeTransaction(): object {
        // Retourner un objet avec une propriété value pour compatibilité
        return (object) ['value' => $this->typetransaction];
    }

    public function setTypeTransaction(string $typetransaction): self {
        $this->typetransaction = $typetransaction;
        return $this;
    }

    public function getMontant(): float {
        return $this->montant;
    }

    public function setMontant(float $montant): self {
        $this->montant = $montant;
        return $this;
    }
}