<?php

use app\core\Application;

class m0010_chama_location
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chamas`
            ADD COLUMN `location` VARCHAR(255) NOT NULL AFTER `status`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chamas`
            DROP COLUMN `location`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
