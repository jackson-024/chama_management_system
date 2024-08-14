<?php

use app\views\tables\Table;

$rowStyles = function ($data) {
    if ($data["join_status"] == "pending") {
        return 'inline-flex items-center justify-center bg-yellow-400 rounded-full shadow mt-4';
    } elseif ($data["join_status"] == "accepted") {
        return 'inline-flex items-center justify-center bg-green-400 rounded-full shadow mt-4';
    } elseif ($data["join_status"] == "rejected") {
        return 'inline-flex items-center justify-center bg-red-400 rounded-full shadow mt-4';
    }
};


$table = Table::begin("Join Requests");

echo $table->TableHeader($requests, true);
echo $table->TableData($requests, [
    function ($data) {
        if ($data["join_status"] == "pending") {
            return '
            <button onclick="approveJoin(' . $data["id"] . ')" class="btn-approve" id="join-approve">
                Approve
                <div class="spinner"></div>     
            </button>
            <button onclick="rejectJoin(' . $data["id"] . ')" class="btn-reject" id="join-reject">
                Reject
                <div class="spinner"></div>
            </button>
        ';
        }
    }
], $rowStyles);

Table::end();
