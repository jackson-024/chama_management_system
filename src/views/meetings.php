<?php

use app\core\Application;
use app\views\tables\Table;

$rowStyles = function ($data) {
};

$createMeetingUrl = "";
$createMeeting = "";

if (Application::$app->session->get("user_role") == 4) {
    $createMeetingUrl = "create-meeting";
    $createMeeting = "Create meeting";
}


$table = Table::begin("Meetings", $createMeetingUrl, $createMeeting);

echo $table->TableHeader($meetings, false);
echo $table->TableData($meetings, [], $rowStyles);

Table::end();
