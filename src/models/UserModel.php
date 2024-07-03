<?php

namespace app\models;

class UserModel extends DbModel
{
    public string $firstName = '';
    public string $lastName = '';
    public string $userName = '';
    public string $phoneNumber = '';
    public string $email = '';
    public string $password  = '';
    public string $confirmPassword  = '';
    public string $role_id  = '';
    public string $status  = 'pending';
    public string $location  = '';
    public string $gender  = '';
    public string $id_number  = '';
    public ?string $chama_id = null; // Allow null

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "firstName",
            "lastName",
            "userName",
            "phoneNumber",
            "email",
            "password",
            "role_id",
            "status",
            "id_number",
            "location",
            "gender",
        ];
    }

    public function labels(): array
    {
        return [
            "firstName" => "First Name",
            "lastName" => "Last Name",
            "userName" => "User Name",
            "phoneNumber" => "Phone Number",
            "email" => "Email",
            "password" => "Password",
            "confirmPassword" => "Confirm Password",
            "id_number" => "Id Number",
            "location" => "Location",
            "gender" => "Gender",
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'userName' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL,  [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'phoneNumber' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 10], [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 4]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'id_number' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], [self::RULE_MAX, 'max' => 10], [self::RULE_MIN, 'min' => 6]],
            'location' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED]
        ];
    }

    public function register()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        // $this->role_id = 1;
        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
