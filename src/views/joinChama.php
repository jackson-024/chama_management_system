<div class="flex-container">
    <div class="content-container">
        <div class="welcome-container">
            <img class="logo" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="main-title">Welcome To CHAMAgo</h2>
            <p class="subtitle">
                Proceed by choose any of the options below.
            </p>
        </div>

        <div class="card-container">
            <ul class="card-list">

                <?php foreach ($chamas as $key => $value) : ?>
                    <li>
                        <div class="card-card">
                            <p class="">
                                Name:
                                <span class="card-text">
                                    <?php echo $value['name']; ?>
                                </span>
                            </p>

                            <p class="mt-1 ">
                                Description:
                                <span class="card-text">
                                    <?php echo $value['description']; ?>
                                </span>
                            </p>

                            <p class="mt-1 ">
                                Location:
                                <span class="card-text">
                                    <?php echo $value['location']; ?>
                                </span>
                            </p>
                            <p class="mt-1 ">
                                Contribution period:
                                <span class="card-text">
                                    <?php echo $value['contribution_period']; ?> days
                                </span>
                            </p>
                            <p class="mt-1 ">
                                Contribution amount:
                                <span class="card-text">
                                    KSH <?php echo $value['contribution_amount'] ?>
                                </span>
                            </p>
                            <form action="" method="post">
                                <input type="hidden" name="chama_id" value="<?php echo $value['id']; ?>">

                                <button class="card-button" type="submit">
                                    Join Chama
                                </button>
                            </form>

                        </div>
                    </li>


                <?php endforeach ?>
            </ul>
        </div>

    </div>
</div>