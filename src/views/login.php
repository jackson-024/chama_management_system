<div class="flex h-screen">
    <div class="flex flex-1 flex-col md:flex-row items-center justify-center md:justify-end px-4 py-12 sm:px-6 lg:px-20 xl:px-24 mx-auto">
        <div class="mx-auto space-y-2">
            <img class="h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="text-3xl font-bold leading-9 tracking-tight text-gray-900">Welcome to <span class="text-blue-500">CHAMAgo</span></h2>
            <h2 class="text-xl font-medium leading-9 tracking-tight text-gray-900">Sign in to your member account</h2>
            <p class="mt-2 text-sm leading-6 text-gray-600">
                Not a member?
                <a href="register" class="font-semibold text-indigo-600 hover:text-indigo-500">Register</a>
            </p>
        </div>

        <div class="mx-auto w-full max-w-sm lg:w-96">

            <div class="mt-10">
                <div>
                    <?php $form = app\views\forms\Form::begin("", "post") ?>

                    <?php echo $form->field($model, 'email') ?>

                    <?php echo $form->field($model, 'password')->passwordField() ?>

                    <?php app\views\forms\Form::button("Login") ?>

                    <?php app\views\forms\Form::end() ?>

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
    </div> -->
</div>