<?php

use app\core\Application;

class m0025_user_loans
{
    public function up()
    {
        $db = Application::$app->db;
        $sql_stmt = "
              CREATE TABLE IF NOT EXISTS user_loans (
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_id INT NULL,
                chama_id INT NULL,
                amount FLOAT NOT NULL,
                repayable_amount FLOAT NOT NULL,
                loan_repayment_period enum('10','20','30') NOT NULL,
                due_date DATE NOT NULL,
                loan_status enum('active','inactive', 'pending', 'defaulted', 'rejected') NOT NULl,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_loan FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
                CONSTRAINT fk_chama_loan FOREIGN KEY (chama_id) REFERENCES chamas(id) ON DELETE SET NULL ON UPDATE CASCADE
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
