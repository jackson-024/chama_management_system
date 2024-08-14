<?php

namespace app\models;

class ChamaWalletModel extends DbModel
{
    public ?string $id = null;
    public int $chama_id;
    public float $debit = 0;
    public float $credit = 0;
    public float $balance = 0;

    public function tableName(): string
    {
        return 'chama_wallet';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "chama_id",
            "debit",
            "credit",
            "balance",
        ];
    }

    public function labels(): array
    {
        return [];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'chama_id' => [self::RULE_REQUIRED],
            'debit' => [self::RULE_REQUIRED],
            'credit' => [self::RULE_REQUIRED],
            'balance' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
