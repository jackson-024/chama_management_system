<?php

// Generate user options
$userOptions = array();

foreach ($userAccs as $user) {
    $userOptions[$user['user_id']] = $user['userName']; // or any other representation
}
?>

<div class="container">
    <div class="header">
        <div class="">
            <h1 class="title">Create fine</h1>
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

                    <?php echo $form->field($model, 'amount')->numberField() ?>
                    <?php echo $form->field($model, 'reason') ?>

                    <?php app\views\forms\Form::button("Fine") ?>

                    <?php app\views\forms\Form::end() ?>

                </div>
            </div>
        </div>

    </div>
</div>