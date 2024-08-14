<?php

namespace app\core;

class Database
{
    public \PDO $pdo;

    // initialize the database
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? "";
        $user = $config["user"] ?? "";
        $password = $config["password"] ?? "";

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    // function used to apply migrations
    public function applyMigrations()
    {
        $this->createMigrationsTable(); // create migrations table if none exits

        $appliedMigrations = $this->getAppliedMigrations(); //get applied migrations
        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/src/migrations'); // scan migrations directory to get migrations

        $notAppliedMigrations = array_diff($files, $appliedMigrations);

        foreach ($notAppliedMigrations as $migration) {
            if ($migration ===  "." || $migration === "..") {
                continue;
            }

            require_once Application::$ROOT_DIR . '/src/migrations/' . $migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();

            $this->log("Applying migration $migration");

            $instance->up();

            $this->log("Applied migration $migration");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations applied");
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT PRIMARY KEY AUTO_INCREMENT,
                migration VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function getAppliedMigrations()
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn ($m) => "('$m')", $migrations));

        $stmt = $this->pdo->prepare("
            INSERT INTO migrations (migration) VALUES $str
        ");
        $stmt->execute();
    }

    public function log($message)
    {
        echo '[' . date("Y-m-d H:i:s") . '] -' . $message . PHP_EOL;
    }
}
