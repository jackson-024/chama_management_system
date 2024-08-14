<?php

use app\core\Application;

class m0029_update_loan_prod
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_product`
            ADD COLUMN `name` VARCHAR(255) NOT NULL after `id`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_poduct` 
            drop column `name`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
