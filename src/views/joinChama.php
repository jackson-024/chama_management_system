<div class="flex h-screen">
    <div class="flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-20 xl:px-24 mx-auto max-w-lg w-full">
        <div class="mx-auto space-y-2">
            <img class="h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Welcome To CHAMAgo</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Proceed by choose any of the options below
            </p>
        </div>

        <div class="mx-auto w-full max-w-sm">
            <ul class="mt-4 space-y-2">

                <?php foreach ($chamas as $key => $value) : ?>
                    <li>
                        <div href="#" class="block h-full rounded-lg border border-gray-700 p-4 hover:border-indigo-400">
                            <p class="font-medium">
                                Name:
                                <span class="text-gray-600">
                                    <?php echo $value['name']; ?>
                                </span>
                            </p>

                            <p class="mt-1 font-medium">
                                Description:
                                <span class="text-gray-600">
                                    <?php echo $value['description']; ?>
                                </span>
                            </p>

                            <p class="mt-1 font-medium">
                                Location:
                                <span class="text-gray-600">
                                    <?php echo $value['location']; ?>
                                </span>
                            </p>
                            <p class="mt-1 font-medium">
                                Contribution period:
                                <span class="text-gray-600">
                                    <?php echo $value['contribution_period']; ?> days
                                </span>
                            </p>
                            <p class="mt-1 font-medium">
                                Contribution amount:
                                <span class="text-gray-600">
                                    KSH <?php echo $value['contribution_amount'] ?>
                                </span>
                            </p>
                            <form action="" method="post">
                                <input type="hidden" name="chama_id" value="<?php echo $value['id']; ?>">

                                <button class="inline-flex items-center justify-center overflow-hidden rounded border border-current mt-3 px-8 py-3 text-indigo-600 hover:bg-indigo-600 hover:text-white w-full" type="submit">
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