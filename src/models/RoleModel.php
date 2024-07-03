<?php

namespace app\models;

class RoleModel extends DbModel
{
    public string $role = '';

    public function tableName(): string
    {
        return 'roles';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "role",
        ];
    }


    // function to provide registration rules
    public function rules(): array
    {
        return [
            'role' => [self::RULE_REQUIRED],
        ];
    }

    public function save()
    {
        return parent::save();
    }
}
