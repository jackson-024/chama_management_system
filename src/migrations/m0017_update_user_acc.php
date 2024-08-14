<?php

use app\core\Application;

class m0017_update_user_acc
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_accounts`
            MODIFY chama_id INT Null;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_accounts`
            MODIFY chama_id NOT Null;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
