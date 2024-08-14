<?php

namespace app\models;

class AllocateModel extends DbModel
{
    public ?string $id = null;
    public int $user_id;
    public int $chama_id;
    public float $amount = 0;

    public function tableName(): string
    {
        return 'allocation';
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
            "amount",
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
            'amount' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
