<div class="container">
    <div class="header">
        <div class="left">
            <h1>Chama Profile</h1>
        </div>
        <div>
            <button onclick="history.back()" class="btn-back">Back</button>
        </div>
    </div>

    <div class="chama-details">
        <div class="flex">
            <div class="">
                <h3 class="title">Chama Details</h3>
            </div>

            <div>
                <?php if ($chama->{"status"} == "pending") : ?>
                    <button onclick='approveChama(<?php echo json_encode($chama->{"id"}); ?>)' class="btn-approve">Approve</button>
                    <button onclick='rejectChama(<?php echo json_encode($chama->{"id"}); ?>)' class="btn-reject">Reject</button>

                <?php else : ?>
                    <button onclick='approveChama(<?php echo json_encode($chama->{"id"}); ?>)' class="btn-reject">Deactivate</button>
                <?php endif ?>
            </div>
        </div>
        <div class="grid">
            <?php foreach ($chama as $key => $value) : ?>
                <?php if ($key == "errors") : ?>
                    <?php continue; ?>
                <?php endif ?>
                <?php if ($key == "id") : ?>
                    <?php continue; ?>
                <?php endif ?>
                <p class="detail">
                    <?php echo $key; ?>:
                    <span class="detail-value">
                        <?php echo $value; ?>
                    </span>
                </p>
            <?php endforeach ?>
        </div>
    </div>
</div>