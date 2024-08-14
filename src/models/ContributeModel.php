<?php

namespace app\models;

class ContributeModel extends DbModel
{
    public ?string $id = null;
    public int $user_id;
    public int $chama_id;
    public float $debit = 0;
    public float $credit = 0;
    public float $balance = 0;

    public function tableName(): string
    {
        return 'contributions';
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
            "credit" => "Amount"
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'chama_id' => [self::RULE_REQUIRED],
            'credit' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
