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

$table = Table::begin("Chama wallet", "", "");

echo $table->TableHeader($chamaRecords, false);
echo $table->TableData($chamaRecords, [], $rowStyles);

Table::end();
