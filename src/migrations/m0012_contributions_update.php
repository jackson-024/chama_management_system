<?php

use app\core\Application;

class m0012_contributions_update
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `contributions`
            ADD COLUMN `debit` FLOAT NOT NULL AFTER `chama_id`,
            ADD COLUMN `credit` FLOAT NOT NULL AFTER `debit`,
            DROP COLUMN `amount`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `contributions`
            DROP COLUMN `debit`,
            DROP COLUMN `credit`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
