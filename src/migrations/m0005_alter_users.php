<?php

use app\core\Application;

class m0005_alter_users
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            ADD COLUMN `id_number` VARCHAR(20) NOT NULL AFTER `email`,
            ADD COLUMN `location` VARCHAR(255) NOT NULL AFTER `id_number`,
            ADD COLUMN `gender` VARCHAR(255) NOT NULL AFTER `location`,
            MODIFY COLUMN `status` ENUM('pending', 'active', 'inactive');
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP COLUMN `id_number`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
