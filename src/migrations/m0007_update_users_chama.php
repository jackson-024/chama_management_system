<?php

use app\core\Application;

class m0007_update_users_chama
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            ADD COLUMN `chama_id` INT(11) NULL AFTER `gender`,
            ADD CONSTRAINT `fk_user_chama` FOREIGN KEY (`chama_id`) REFERENCES `chamas`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP FOREIGN KEY `fk_user_chama`,
            DROP COLUMN `chama_id`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
