<?php

use app\core\Application;

class m0009_chama_status
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chamas`
            ADD COLUMN `status` ENUM('pending', 'active', 'inactive') NOT NULL AFTER `chairperson_id`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `chamas`
            DROP COLUMN `status`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
