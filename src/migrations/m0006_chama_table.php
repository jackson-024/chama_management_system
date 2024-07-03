<?php

use app\core\Application;

class m0006_chama_table
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS chamas (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                contribution_period ENUM('10', '20', '30') NOT NULL,
                contribution_amount DOUBLE NOT NULL,
                flow ENUM('merry_go_round', 'bank', 'both') NOT NULL,
                chairperson_id INT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_chairperson FOREIGN KEY (chairperson_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `chamas`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
