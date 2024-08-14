<?php

namespace app\models;

class UserWalletModel extends DbModel
{
    public ?string $id = null;
    public int $user_id;
    public int $chama_id;
    public float $debit = 0;
    public float $credit = 0;
    public float $balance = 0;

    public function tableName(): string
    {
        return 'user_wallet';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "user_id",
            "chama_id",
            "debit",
            "credit",
            "balance",
        ];
    }

    public function labels(): array
    {
        return [
            "amount" => "Amount"
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'debit' => [self::RULE_REQUIRED],
            'credit' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
