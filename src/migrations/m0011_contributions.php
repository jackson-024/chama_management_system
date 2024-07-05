<?php

use app\core\Application;

class m0011_contributions
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS contributions (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NULL,
                chama_id INT NULL,
                amount FLOAT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_contribution FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT fk_chama_contribution FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `contributions`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
