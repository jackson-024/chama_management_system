<?php

use app\views\tables\Table;

$rowStyles = function ($data) {
    if ($data["status"] == "pending") {
        return 'inline-flex items-center justify-center bg-yellow-400 rounded-full shadow mt-4';
    } elseif ($data["status"] == "active") {
        return 'inline-flex items-center justify-center bg-green-400 rounded-full shadow mt-4';
    } elseif ($data["status"] == "inactive") {
        return 'inline-flex items-center justify-center bg-red-400 rounded-full shadow mt-4';
    }
};

$table = Table::begin("User Loans", "create-loan", "Borrow");

echo $table->TableHeader($loans, true);
echo $table->TableData($loans, [
    function ($data) {
        return '<a href="my-loans?id=' . $data["id"] . '" class="link">
        Profile
    </a>';
    }
], $rowStyles);

Table::end();
