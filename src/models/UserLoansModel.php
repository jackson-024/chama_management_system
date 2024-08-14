<?php

namespace app\models;

class UserLoansModel extends DbModel
{
    public ?int $id = null;
    public ?int $user_id = null;
    public ?int $chama_id = null;
    public ?int $loan_prod_id = null;
    public float $amount = 0;
    public ?float $repayable_amount = null;
    public ?int $loan_repayment_period = null;
    public ?string $due_date = null;
    public ?string $loan_status = null;

    public function tableName(): string
    {
        return 'user_loans';
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
            "loan_prod_id",
            "amount",
            "repayable_amount",
            "loan_repayment_period",
            "due_date",
            "loan_status",
        ];
    }

    public function labels(): array
    {
        return [
            "loan_prod_id" => "Loan Product",
            "amount" => "Amount",
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
