<?php

use app\core\Application;

class m0015_user_accounts
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS user_accounts (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                chama_id INT NOT NULL,
                role_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_acc FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_chama_acc FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE CASCADE,
                CONSTRAINT fk_role_acc FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `user_accounts`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
