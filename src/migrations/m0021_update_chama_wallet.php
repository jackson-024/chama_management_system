<?php

use app\core\Application;

class m0021_update_chama_wallet
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chama_wallet`
            ADD COLUMN `balance` FLOAT NOT NULL after `credit`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chama_wallet` 
            drop column `balance`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
