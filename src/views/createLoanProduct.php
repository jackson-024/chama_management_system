<div class="container">
    <div class="header">
        <div class="">
            <h1 class="title">Create Loan Product</h1>
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

                    <?php echo $form->field($model, 'name') ?>
                    <?php echo $form->field($model, 'max_amount')->numberField() ?>
                    <?php echo $form->field($model, 'loan_repayment_period')->numberField() ?>
                    <?php echo $form->field($model, 'loan_interest_rate')->numberField() ?>
                    <?php echo $form->field($model, 'status')->selectField([
                        "active" => "Active",
                        "inactive" => "Inactive",
                    ]) ?>

                    <?php app\views\forms\Form::button("create") ?>

                    <?php app\views\forms\Form::end() ?>

                </div>
            </div>
        </div>

    </div>
</div>