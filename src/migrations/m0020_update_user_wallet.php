<?php

use app\core\Application;

class m0020_update_user_wallet
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_wallet`
            ADD COLUMN `balance` FLOAT NOT NULL after `credit`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_wallet` 
            drop column `balance`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
