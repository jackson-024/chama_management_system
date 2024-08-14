<?php

use app\views\tables\Table;

$rowStyles = function ($data) {
};

$table = Table::begin("Chama Contributions", null, null, true);

echo $table->TableHeader($chamaRecords, false);
echo $table->TableData($chamaRecords, [], $rowStyles);

Table::end();
