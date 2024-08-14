<?php

namespace app\models;

use app\core\Application;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_NUMBER = 'number';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule; // if rule name is a string

                //if rule name is an array
                if (!is_string($ruleName)) {
                    $ruleName = $ruleName[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                // filter_var is a php function
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_NUMBER && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($attribute, self::RULE_NUMBER);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class']; // class name of the model
                    $uniqueAttr = $rule['attribute'] ?? $attribute; // attribute name of the model
                    $tableName = $className::tableName();

                    $stmt = Application::$app->db->prepare("
                        SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr
                    ");

                    $stmt->bindValue(":$uniqueAttr", $value);

                    $stmt->execute();

                    $record = $stmt->fetchObject();

                    if ($record) {
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? "";

        foreach ($params as $key => $value) {
            $message =  str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addErrorMessage(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'Must be a valid email address',
            self::RULE_NUMBER => 'Must be a valid number',
            self::RULE_MIN => 'Minimum length is {min}',
            self::RULE_MAX => 'Maximum length is {max}',
            self::RULE_MATCH => 'This field does not match with {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    public function hasError($attribute)
    {
        // check if error exits 
        return $this->errors[$attribute] ?? false;
    }

    public function getError($attribute)
    {
        return $this->errors[$attribute][0] ?? ''; // return first error


    }
}
