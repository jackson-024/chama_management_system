<?php

namespace app\models;

use app\core\Application;
use PDO;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;

    // database connection
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    // function used to save records in database dynamically
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);

        $stmt = self::prepare("
            INSERT INTO $tableName (" . implode(",", $attributes) . ")
            VALUES (" . implode(",", $params) . ")
        ");

        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }

        $stmt->execute();

        return true;
    }

    public function findOne($where) // where is an associated array
    {
        $tableName = $this->tableName();

        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }

        $stmt->execute();

        return $stmt->fetchObject(static::class);
    }

    public function findAll()
    {
        $tableName = $this->tableName();
        $sqlStmt = self::prepare("SELECT * FROM $tableName");
        $sqlStmt->execute();
        return $sqlStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOne($where, $values)
    {
        $tableName = $this->tableName();

        $valueAttributes = array_keys($values);
        $sqlValues = implode(", ", array_map(fn ($attr) => "$attr = :$attr", $valueAttributes));

        $attributes = array_keys($where);
        $sql = implode(", ", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $stmt = self::prepare("UPDATE $tableName SET $sqlValues WHERE $sql");

        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }

        foreach ($values as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }


        $stmt->execute();
        return true;
    }
}
