<?php

use app\core\Application;

class m0018_user_update
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP COLUMN `role_id`, 
            DROP COLUMN `chama_id`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
