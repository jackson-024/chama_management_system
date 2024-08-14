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

// $table = Table::begin("Users", "create-user", "create user");
$table = Table::begin("Users");

echo $table->TableHeader($users, true);
echo $table->TableData($users, [
    function ($data) {
        return '<a href="user-profile?id=' . $data["id"] . '" class="link">
        Profile
    </a>';
    }
], $rowStyles);

Table::end();
