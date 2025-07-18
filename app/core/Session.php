<?php

namespace PMT\SRC\Entity;

use PMT\APP\CORE\ABSTRACT\AbstractEntity;

class CompteEntity extends AbstractEntity {
    private int $id;
    private string $num_compte;
    private float $solde;
    private string $num_telephone;
    private string $date_creation;
    private TypeCompte $TypeCompte;
    private ?UsersEntity $userr;
    private array $transactions = []; // tableau d'objets TransactionEntity

    public function __construct(
        int $id = 0,
        string $num_compte = "",
        float $solde = 0.0,
        string $num_telephone = "",
        string $date_creation = "",
        TypeCompte $TypeCompte = TypeCompte::Principal,
        ?UsersEntity $userr = null,
        array $transactions = []
    ) {
        $this->id = $id;
        $this->num_compte = $num_compte;
        $this->solde = $solde;
        $this->num_telephone = $num_telephone;
        $this->date_creation = $date_creation;
        $this->TypeCompte = $TypeCompte;
        $this->userr = $userr;
        $this->transactions = $transactions;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "num_compte" => $this->num_compte,
            "solde" => $this->solde,
            "num_telephone" => $this->num_telephone,
            "date_creation" => $this->date_creation,
            "type" => $this->TypeCompte?->value ?? null,
            "users" => $this->userr?->toArray() ?? null,
            "transactions" => array_map(fn($t) => $t->toArray(), $this->transactions)
        ];
    }

    public static function toObject($data): static {
        $transactions = [];

        if (isset($data["transactions"]) && is_array($data["transactions"])) {
            foreach ($data["transactions"] as $t) {
                $transactions[] = TransactionEntity::toObject($t);
            }
        }

        return new static(
            $data["id"] ?? 0,
            $data["num_compte"] ?? "",
            $data["solde"] ?? 0.0,
            $data["num_telephone"] ?? "",
            $data["date_creation"] ?? "",
            isset($data["type"]) ? TypeCompte::from($data["type"]) : TypeCompte::Principal,
            isset($data["users"]) ? UsersEntity::toObject($data["users"]) : null,
            $transactions
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

    public function getTypeCompte(): TypeCompte {
        return $this->TypeCompte;
    }

    public function setTypeCompte(TypeCompte $TypeCompte): self {
        $this->TypeCompte = $TypeCompte;
        return $this;
    }

    public function getUserr(): ?UsersEntity {
        return $this->userr;
    }

    public function setUserr(?UsersEntity $userr): self {
        $this->userr = $userr;
        return $this;
    }

    public function getTransactions(): array {
        return $this->transactions;
    }

    public function setTransactions(array $transactions): self {
        $this->transactions = $transactions;
        return $this;
    }

    public function addTransaction(TransactionEntity $transaction): self {
        $this->transactions[] = $transaction;
        return $this;
    }
}
