<div class="flex-container">
    <div class="content-container">
        <div class="welcome-container">
            <img class="logo" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="main-title">Welcome to <span class="highlight">CHAMAgo</span></h2>
            <h2 class="subtitle">Create your member account</h2>
            <p class="text-sm">
                Already a member?
                <a href="login" class="login-link">Login</a>
            </p>
        </div>

        <div class="form-container">
            <div class="form-wrapper">
                <?php $form = app\views\forms\Form::begin("", "post") ?>

                <div class="grid-container">
                    <?php echo $form->field($model, 'firstName') ?>
                    <?php echo $form->field($model, 'lastName') ?>
                </div>
                <?php echo $form->field($model, 'userName') ?>

                <div class="grid-container">
                    <?php echo $form->field($model, 'phoneNumber') ?>
                    <?php echo $form->field($model, 'id_number') ?>
                </div>

                <?php echo $form->field($model, 'email')->emailField() ?>

                <div class="grid-container">
                    <?php echo $form->field($model, 'location') ?>

                    <?php echo $form->field($model, 'gender')->selectField([
                        'male' => 'Male',
                        'female' => 'Female'
                    ]); ?>
                </div>

                <div class="grid-container">
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                    <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
                </div>

                <div class="spacing"></div>

                <?php app\views\forms\Form::button("create account") ?>

                <?php app\views\forms\Form::end() ?>

            </div>
        </div>
    </div>
</div>