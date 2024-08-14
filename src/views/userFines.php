<?php

use app\views\tables\Table;

$rowStyles = function ($data) {
};

$table = Table::begin("Member Fines", null, null);

echo $table->TableHeader($fines, true);
echo $table->TableData($fines, [
    function ($data) {
        return '<a href="fine-profile?id=' . $data["id"] . '" class="link">
        Profile
    </a>';
    }
], $rowStyles);

Table::end();
