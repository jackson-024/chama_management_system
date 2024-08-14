<?php

use app\core\Application;

class m0014_user_wallet
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS user_wallet (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                debit FLOAT NOT NULL,
                credit FLOAT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_wallet FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `user_wallet`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
