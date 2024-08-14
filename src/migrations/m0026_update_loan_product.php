<?php

use app\core\Application;

class m0026_update_loan_product
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_product`
            MODIFY `status` enum('active', 'inavtive') NOT NULL after `loan_interest_rate`;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_poduct` 
            drop column `status`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
