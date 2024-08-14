<div class="flex-container">
    <div class="content-container">
        <div class="welcome-container">
            <img class="logo" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="main-title">Welcome To CHAMAgo</h2>
            <p class="subtitle">
                Proceed by choose any of the options below
            </p>
        </div>

        <div class="card-container">
            <div>
                <?php $form = app\views\forms\Form::begin("", "post") ?>

                <?php echo $form->field($model, 'name') ?>
                <?php echo $form->field($model, 'description') ?>

                <div class="grid grid-cols-2 gap-5">
                    <?php echo $form->field($model, 'contribution_period')->selectField([
                        '10' => '10 Days',
                        '20' => '20 Days',
                        '30' => '30 Days',
                    ]); ?>

                    <?php echo $form->field($model, 'contribution_amount') ?>
                </div>


                <?php echo $form->field($model, 'flow')->selectField([
                    'merry_go_round' => 'Merry go Round',
                    'bank' => 'Save',
                    'both' => 'Both',
                ]); ?>

                <?php echo $form->field($model, 'location') ?>

                <?php app\views\forms\Form::button("create") ?>

                <?php app\views\forms\Form::end() ?>

            </div>
        </div>

    </div>
</div>