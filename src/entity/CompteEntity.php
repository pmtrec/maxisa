<?php

namespace PMT\SRC\Entity;

use PMT\APP\CORE\ABSTRACT\AbstractEntity;

class CompteEntity extends AbstractEntity {
    private int $id;
    private string $num_compte;
    private float $solde;
    private string $num_telephone;
    private string $date_creation;
    private ?string $typeCompte;
    private ?UsersEntity $userr;
    private ?TransactionEntity $transaction;

    public function __construct(
        ?int $id = 0,
        string $num_compte = "",
        float $solde = 0.0,
        string $num_telephone = "",
        string $date_creation = "",
        ?string $typeCompte = null,
        ?UsersEntity $userr = null,
        ?TransactionEntity $transaction = null
    ) {
        $this->id = $id ?? 0;
        $this->num_compte = $num_compte;
        $this->solde = $solde;
        $this->num_telephone = $num_telephone;
        $this->date_creation = $date_creation;
        $this->typeCompte = $typeCompte;
        $this->userr = $userr;
        $this->transaction = $transaction;
    }

    public static function toArray(): array {
        return [
            "id" => $this->id,
            "num_compte" => $this->num_compte,
            "solde" => $this->solde,
            "num_telephone" => $this->num_telephone,
            "date_creation" => $this->date_creation,
            "type" => $this->typeCompte,
            "users" => $this->userr?->toArray(),
            "transaction" => $this->transaction?->toArray()
        ];
    }

    public static function toObject($data): static {
        return new static(
            $data["id"] ?? 0,
            $data["num_compte"] ?? "",
            floatval($data["solde"] ?? 0.0),
            $data["num_telephone"] ?? "",
            $data["created_at"] ?? $data["date_creation"] ?? "",
            $data["type_type_compte_enum"] ?? null,
            isset($data["userr"]) ? UsersEntity::toObject($data["userr"]) : null,
            isset($data["transaction"]) ? TransactionEntity::toObject($data["transaction"]) : null
        );
    }

    // Getters et setters

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getNum_compte(): string {
        return $this->num_compte;
    }

    public function setNum_compte(string $num_compte): self {
        $this->num_compte = $num_compte;
        return $this;
    }

    public function getSolde(): float {
        return $this->solde;
    }

    public function setSolde(float $solde): self {
        $this->solde = $solde;
        return $this;
    }

    public function getNum_telephone(): string {
        return $this->num_telephone;
    }

    public function setNum_telephone(string $num_telephone): self {
        $this->num_telephone = $num_telephone;
        return $this;
    }

    public function getDate_creation(): string {
        return $this->date_creation;
    }

    public function setDate_creation(string $date_creation): self {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getTypeCompte(): ?string {
        return $this->typeCompte;
    }

    public function setTypeCompte(?string $typeCompte): self {
        $this->typeCompte = $typeCompte;
        return $this;
    }

    public function getUserr(): ?UsersEntity {
        return $this->userr;
    }

    public function setUserr(?UsersEntity $userr): self {
        $this->userr = $userr;
        return $this;
    }

    public function getTransaction(): ?TransactionEntity {
        return $this->transaction;
    }

    public function setTransaction(?TransactionEntity $transaction): self {
        $this->transaction = $transaction;
        return $this;
    }
}