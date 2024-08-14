<?php

use app\core\Application;

class m0028_user_loan_update
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_loans`
            ADD COLUMN `loan_prod_id` INT NOT NULL after `chama_id`,
            ADD CONSTRAINT `fk_loan_prod` FOREIGN KEY (`loan_prod_id`) REFERENCES `loan_product`(`id`);
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            ALTER TABLE `user_loans` 
            drop column `loan_prod_id`;
         ";
        $db->pdo->exec($sql_stmt);
    }
}
