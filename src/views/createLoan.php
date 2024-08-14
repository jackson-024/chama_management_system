<?php

// Generate user options

use app\core\Application;

$loanProductsOpt = array();

foreach ($loanProducts as $product) {
    $loanProductsOpt[$product['id']] = $product['name']; // or any other representation
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
            <h1 class="title">Create Loan</h1>
        </div>
        <div>
            <button onclick="history.back()" class="btn-back">Back</button>
        </div>
    </div>

    <div class="content-container">

        <?php if (count($loanProductsOpt) <= 0) : ?>
            No loan products

            <?php if (Application::$app->session->get("user_role") == 2 || Application::$app->session->get("user_role") == 3) : ?>
                <a href="/create-loan-product" class="btn-approve">Create Loan Product</a>

            <?php endif; ?>
        <?php else : ?>
            <div class="form-container">
                <div class="form-wrapper">
                    <div>
                        <?php $form = app\views\forms\Form::begin("", "post") ?>

                        <?php echo $form->field($model, 'loan_prod_id')->selectField($loanProductsOpt); ?>
                        <?php echo $form->field($model, 'amount')->numberField(); ?>

                        <?php app\views\forms\Form::button("Borrow") ?>

                        <?php app\views\forms\Form::end() ?>

                    </div>
                </div>
            </div>


        <?php endif; ?>
    </div>
</div>