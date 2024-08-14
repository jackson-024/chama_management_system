<?php

use app\core\Application;
use app\views\tables\Table;

$rowStyles = function ($data) {
};

$createFineUrl = "";
$createFines = "";

if (Application::$app->session->get("user_role") == 2 || Application::$app->session->get("user_role") == 3 || Application::$app->session->get("user_role") == 4) {
    $createFineUrl = "create-fine";
    $createFines = "Create fine";
}


$table = Table::begin("Chama Fines", $createFineUrl, $createFines);

echo $table->TableHeader($fines, true);
echo $table->TableData($fines, [
    function ($data) {
        return '<a href="fine-profile?id=' . $data["id"] . '" class="link">
        Profile
    </a>';
    }
], $rowStyles);

Table::end();
