<?php

use app\core\Application;

class m0019_update_contributions
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `contributions`
            ADD COLUMN `balance` FLOAT NOT NULL after `credit`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `contributions` 
            drop column `balance`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
