        <div class="container">
            <div class="header">
                <div class="">
                    <h1 class="title">Allocation form</h1>
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

                            <?php echo $form->field($model, 'amount')->numberField() ?>

                            <?php app\views\forms\Form::button("Contribute") ?>

                            <?php app\views\forms\Form::end() ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>