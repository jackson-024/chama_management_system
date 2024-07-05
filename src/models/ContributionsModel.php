<?php

namespace app\models;

class ContributionsModel extends DbModel
{
    public string $name = '';
    public string $description = '';
    public string $contribution_period = '';
    public string $contribution_amount = '';
    public string $flow = '';
    public string $chairperson_id = '';
    public string $status = 'pending';
    public string $location = '';

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
        ];
    }

    public function labels(): array
    {
        return [
            "name" => "Name",
            "description" => "Description",
            "contribution_period" => "Coontribution Period",
            "contribution_amount" => "Coontribution Amount",
            "flow" => "Flow",
            "location" => "Location",
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'contribution_period' => [self::RULE_REQUIRED],
            'contribution_amount' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'flow' => [self::RULE_REQUIRED],
            'location' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

}