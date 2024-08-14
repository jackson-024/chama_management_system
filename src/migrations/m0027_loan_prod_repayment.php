<?php

use app\core\Application;

class m0027_loan_prod_repayment
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_product`
            MODIFY loan_repayment_period INT NOT Null;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `loan_product`
            MODIFY loan_repayment_period NOT Null;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
