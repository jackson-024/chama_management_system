<?php

use app\core\Application;

class m0003_alter_users_table
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP COLUMN `role`,
            ADD COLUMN `role_id` INT(11) NULL AFTER `password`,
            ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP FOREIGN KEY `fk_users_roles`,
            DROP COLUMN `role_id`,
            ADD COLUMN `role` VARCHAR(255) NULL AFTER `email`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
