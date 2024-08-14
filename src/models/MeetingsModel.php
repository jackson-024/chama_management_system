<?php

namespace app\models;

class MeetingsModel extends DbModel
{
    public ?string $id = null;
    public ?int $chama_id = null;
    public ?string $date = null;
    public ?string $time = null;
    public ?string $venue = null;
    public ?string $purpose = null;

    public function tableName(): string
    {
        return 'meetings';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            "chama_id",
            "date",
            "time",
            "venue",
            "purpose",
        ];
    }

    public function labels(): array
    {
        return [
            "date" => "Date",
            "time" => "Time",
            "venue" => "Venue",
            "purpose" => "Purpose",
        ];
    }

    // function to provide registration rules
    public function rules(): array
    {
        return [
            'chama_id' => [self::RULE_REQUIRED],
            'date' => [self::RULE_REQUIRED],
            'time' => [self::RULE_REQUIRED],
            'venue' => [self::RULE_REQUIRED],
            'purpose' => [self::RULE_REQUIRED],
        ];
    }

    public function getDisplayName(): string
    {
        return "";
    }
}
