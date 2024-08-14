<?php

use app\core\Application;

class m0031_fines
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS fines (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                chama_id INT NOT NULL,
                amount FLOAT NOT NULL,
                reason VARCHAR(600) NOT NULL,
                status enum('not_cleared', 'cleared') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_fine FOREIGN KEY (user_id) REFERENCES users(id),
                CONSTRAINT fk_chama_fine FOREIGN KEY (chama_id) REFERENCES chamas(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `fines`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
