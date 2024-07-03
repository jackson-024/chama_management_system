<?php

use app\core\Application;

class m0004_add_status_users
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            ADD COLUMN `status` ENUM('active', 'inactive') NOT NULL AFTER `role_id`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP COLUMN `status`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
