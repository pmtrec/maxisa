<?php

namespace PMT\SRC\Entity;

use PMT\APP\CORE\ABSTRACT\AbstractEntity;

class TransactionEntity extends AbstractEntity {
    private int $id;
    private string $date;
    private TypeTransaction $typetransaction;
    private float $montant;

    public function __construct(
        int $id = 0,
        string $date = "",
        TypeTransaction $typetransaction = TypeTransaction::Depot,
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
            "typetransaction" => $this->typetransaction->value,
            "user_id" => $this->user?->getId() ?? null
        ];
    }

    public static function toObject($data): static {
        return new static(
            $data['id'],
            $data['date'],
            TypeTransaction::from($data['type']),
            $data['montant']
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

    public function getTypeTransaction(): TypeTransaction {
        return $this->typetransaction;
    }

    public function setTypeTransaction(TypeTransaction $typetransaction): self {
        $this->typetransaction = $typetransaction;
        return $this;
    }

    public function getUser(): ?UsersEntity {
        return $this->user;
    }

    public function setUser(UsersEntity $user): self {
        $this->user = $user;
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
