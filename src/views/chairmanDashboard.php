<?php
$hasTreasurer = false;
$hasSecretary = false;

$secretary;
$treasurer;


// Check if any user has role_id 3
foreach ($users as $user) {
    if ($user['role_id'] == 3) {
        $hasTreasurer = true;
        $treasurer = $user;

        continue;
    }
    if ($user['role_id'] == 4) {
        $hasSecretary = true;
        $secretary = $user;
        continue;
    }
}
?>

<div class="header">
    <div class="left">
        <h1>Chairman Dashboard</h1>
        <div class="text-container">
            <p class="detail">Chama Name: <span class="detail-value">
                    <?php echo $chama->name ?></span></p>
            <p class="detail">Status: <span class="detail-value">
                    <?php echo $chama->status ?></span></p>
            <p class="detail">Location: <span class="detail-value">
                    <?php echo $chama->location ?></span></p>
            <p class="detail">Contribution Amt: <span class="detail-value">
                    <?php echo $chama->contribution_amount ?></span></p>
            <p class="detail">Chama type: <span class="detail-value">
                    <?php echo $chama->flow ?></span></p>
        </div>

    </div>
</div>

<!-- Insights -->
<ul class="insights">
    <li><i class='bx bx-show-alt'></i>
        <span class="info">
            <h3>
                <?php echo number_format(count($users)) ?>
            </h3>
            <p>Total Members</p>
        </span>
    </li>
    <li><i class='bx bx-show-alt'></i>
        <span class="info">
            <h3>
                <?php echo number_format(count($joinReqs)) ?>
            </h3>
            <p>New Join Requests</p>
        </span>
    </li>
    <li><i class='bx bx-line-chart'></i>
        <span class="info">
            <h3>
                <?php echo number_format($lastUWRecord["balance"]) ?>

            </h3>
            <p>Member Wallet Balance</p>
        </span>
    </li>
    <li><i class='bx bx-line-chart'></i>
        <span class="info">
            <h3>
                <?php echo number_format($lastChamaRecord["balance"]) ?>

            </h3>
            <p>Chama Wallet Balance</p>
        </span>
    </li>

    <li><i class='bx bx-show-alt'></i>
        <span class="info">
            <h3>
                <?php echo number_format(count($chamaLoans)) ?>
            </h3>
            <p>Total loans</p>
        </span>
    </li>

    <li><i class='bx bx-show-alt'></i>
        <span class="info">
            <h3>
                <?php echo number_format(count($fines)) ?>
            </h3>
            <p>Fines</p>
        </span>
    </li>

</ul>
<!-- End of Insights -->

<div class="container grid">
    <div class="card-card">

        <?php if ($hasTreasurer == false) : ?>
            <p> No Treasurer nominated</p>

            <a class="card-button" href="/nominate">Nominate treasurer</a>
        <?php else : ?>
            <p>Treasurer name: <?php echo $treasurer["userName"] ?></p>
            <a class="card-button" href="/nominate">update</a>

        <?php endif ?>
    </div>
    <div class="card-card">

        <?php if ($hasSecretary == false) : ?>
            <p> No secretary nominated</p>

            <a class="card-button" href="/nominate">Nominate secretary</a>
        <?php else : ?>
            <p>Secretary name: <?php echo $secretary["userName"] ?></p>
            <a class="card-button" href="/nominate">update</a>
        <?php endif ?>
    </div>
</div>

<div class="grid">
    <div class="card-card">
        <p class="detail">Upcoming meetings</p>

        <?php if ($meetings) : ?>
            <ul class="card-list">
                <?php foreach ($meetings as $meeting => $value) : ?>
                    <li>
                        <div class="card-card">
                            <p class="">
                                Date:
                                <span class="card-text">
                                    <?php echo $value['date']; ?>
                                </span>
                            </p>
                            <p class="">
                                Time:
                                <span class="card-text">
                                    <?php echo $value['time']; ?>
                                </span>
                            </p>
                            <p class="">
                                Venue:
                                <span class="card-text">
                                    <?php echo $value['venue']; ?>
                                </span>
                            </p>
                            <p class="">
                                Purpose:
                                <span class="card-text">
                                    <?php echo $value['purpose']; ?>
                                </span>
                            </p>

                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <div class="text-container">
                <p class="info">No upcoming meetings</p>
            </div> <?php endif; ?>

    </div>
</div>