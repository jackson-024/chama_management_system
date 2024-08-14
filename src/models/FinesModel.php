<?php

namespace app\models;

class FinesModel extends DbModel
{
    public ?string $id = null;
    public ?int $user_id = null;
    public ?int $chama_id = null;
    public ?float $amount = 0;
    public ?string $reason = null;
    public ?string $status = "not_cleared";

    public function tableName(): string
    {
        return 'fines';
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
            "reason",
            "status",
        ];
    }

    public function labels(): array
    {
        return [
            "user_id" => "User Select Member account",
            "amount" => "Amount",
            "reason" => "Reason",
            "status" => "Status",
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'amount' => [self::RULE_REQUIRED],
            'reason' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
