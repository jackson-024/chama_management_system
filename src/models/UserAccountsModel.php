<?php

namespace app\models;

class UserAccountsModel extends DbModel
{
    public ?int $chama_id = null;
    public ?string $user_id = null;
    public ?string $role_id = null;

    public function tableName(): string
    {
        return 'user_accounts';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "chama_id",
            "user_id",
            "role_id",
        ];
    }

    public function labels(): array
    {
        return [
            "user_id" => "User",
            "role_id" => "Role"
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'role_id' => [self::RULE_REQUIRED, self::RULE_NUMBER]
        ];
    }

    public function createUserAccount()
    {
        return parent::save();
    }
}
