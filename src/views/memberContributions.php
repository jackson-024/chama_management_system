<?php

use app\views\tables\Table;

$rowStyles = function ($data) {
};

$table = Table::begin("Member Wallet", "withdraw", "Withdraw", true);

echo $table->TableHeader($userContributions, false);
echo $table->TableData($userContributions, [], $rowStyles);

Table::end();
