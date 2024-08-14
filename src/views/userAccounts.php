<div class="flex-container">
    <div class="content-container">
        <div class="welcome-container">
            <img class="logo" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="main-title">Welcome To CHAMAgo</h2>
            <p class="subtitle">
                Proceed by choosing your account.
            </p>
        </div>

        <div class="card-container">
            <ul class="card-list">
                <?php foreach ($userAccounts as $key => $value) : ?>
                    <li>
                        <div class="card-card">
                            <p class="">
                                User Name:
                                <span class="card-text">
                                    <?php echo $value['userName']; ?>
                                </span>
                            </p>
                            <p class="">
                                Chama Name:
                                <span class="card-text">
                                    <?php echo $value['name']; ?>
                                </span>
                            </p>
                            <p class="">
                                Role:
                                <span class="card-text">
                                    <?php echo $value['role']; ?>
                                </span>
                            </p>
                            <form action="" method="post">
                                <input type="hidden" name="role_id" value="<?php echo $value["role_id"]; ?>">
                                <button class="card-button" type="submit">
                                    Login
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>

    </div>
</div>