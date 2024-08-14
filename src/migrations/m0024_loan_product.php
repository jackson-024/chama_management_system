<?php

use app\core\Application;

class m0024_loan_product
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS loan_product (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                chama_id INT NULL,
                max_amount FLOAT NOT NULL,
                loan_repayment_period enum('10','20','30') NOT NULL,
                loan_interest_rate FLOAT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_chama_product FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $db->pdo->exec($sql_stmt);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql_stmt = "
            DROP TABLE `loan_product`;
        ";
        $db->pdo->exec($sql_stmt);
    }
}
