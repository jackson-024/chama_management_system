<?php

namespace app\models;

class LoanProductModel extends DbModel
{
    public ?int $id = null;
    public ?string $name = null;
    public ?int $chama_id = null;
    public float $max_amount = 0;
    public ?int $loan_repayment_period = null;
    public ?float $loan_interest_rate = null;
    public ?string $status = null;

    public function tableName(): string
    {
        return 'loan_product';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "name",
            "chama_id",
            "max_amount",
            "loan_repayment_period",
            "loan_interest_rate",
            "status"
        ];
    }

    public function labels(): array
    {
        return [
            "name" => "Name",
            "max_amount" => "Maximum Loan Amount",
            "loan_repayment_period" => "Loan Repayment Period (Days)",
            "loan_interest_rate" => "Loan Interest Rate (%)",
            "status" => "Status"
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'chama_id' => [self::RULE_REQUIRED],
            'max_amount' => [self::RULE_REQUIRED],
            'loan_repayment_period' => [self::RULE_REQUIRED],
            'loan_interest_rate' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
