<?php

use app\core\Application;

class m0016_remove_role
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `users`
            DROP CONSTRAINT `fk_users_roles`,
            DROP CONSTRAINT `fk_user_chama`;
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
