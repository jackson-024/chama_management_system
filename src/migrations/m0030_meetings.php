<?php

use app\core\Application;

class m0030_meetings
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS meetings (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                chama_id INT NULL,
                date DATE NOT NULL,
                time TIME NOT NULL,
                venue VARCHAR(255) NOT NULL,
                purpose VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_chama_meeting FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `loan_product`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
