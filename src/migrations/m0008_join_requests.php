<?php

use app\core\Application;

class m0008_join_requests
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS join_request (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NULL,
                chama_id INT NULL,
                join_status ENUM('pending', 'accepted', 'rejected') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_join FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT fk_chama_join FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `join_request`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
