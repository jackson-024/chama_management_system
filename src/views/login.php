<div class="flex-container">
    <div class="content-container">
        <div class="welcome-container">
            <img class="logo" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="main-title">Welcome to <span class="highlight">CHAMAgo</span></h2>
            <h2 class="subtitle">Sign in to your member account</h2>
            <p class="text-sm">
                Not a member?
                <a href="register" class="register-link">Register</a>
            </p>
        </div>

        <div class="form-container">
            <div class="form-wrapper">
                <div>
                    <?php $form = app\views\forms\Form::begin("", "post") ?>

                    <?php echo $form->field($model, 'email')->emailField() ?>

                    <?php echo $form->field($model, 'password')->passwordField() ?>

                    <?php app\views\forms\Form::button("Login") ?>

                    <?php app\views\forms\Form::end() ?>

                </div>
            </div>
        </div>

        <div>
            <p>
                Forgot your password?
                <a href="forgot-password" class="register-link">Reset</a>

            </p>
        </div>
    </div>
</div>