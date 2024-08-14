<?php

// Generate user options
$userOptions = array();

foreach ($userAccs as $user) {
    $userOptions[$user['user_id']] = $user['userName']; // or any other representation
}

$roleOpts = [
    2 => "Chairperson",
    3 => "Treasurer",
    4 => "Secretary",
];

?>


<div class="container">
    <div class="header">
        <div class="">
            <h1 class="title">Nomination form</h1>
        </div>
        <div>
            <button onclick="history.back()" class="btn-back">Back</button>
        </div>
    </div>

    <div class="content-container">

        <div class="form-container">
            <div class="form-wrapper">
                <div>
                    <?php $form = app\views\forms\Form::begin("", "post") ?>

                    <?php echo $form->field($model, 'user_id')->selectField($userOptions); ?>
                    <?php echo $form->field($model, 'role_id')->selectField($roleOpts); ?>

                    <?php app\views\forms\Form::button("Contribute") ?>

                    <?php app\views\forms\Form::end() ?>

                </div>
            </div>
        </div>

    </div>
</div>