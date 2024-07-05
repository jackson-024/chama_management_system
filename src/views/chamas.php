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

$table = Table::begin("Chamas", "create-chama", "create chama");

echo $table->TableHeader($chamas, true);
echo $table->TableData($chamas, [
    function ($data) {
        return '<a href="chama-profile?id=' . $data . '" class="cursor-pointer block rounded-md px-3 py-2 text-center text-sm font-semibold text-indigo-600 shadow-sm ring-1 ring-indigo-600 hover:bg-indigo-600 hover:text-white">
        Profile
    </a>';
    }
], $rowStyles);

Table::end();
