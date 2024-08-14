<?php

use app\core\Application;

class m0023_user_wallet_update
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_wallet`
            ADD COLUMN `chama_id` INT NOT NULL after `user_id`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chama_wallet` 
            drop column `chama_id`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
