<?php

use app\core\Application;

// Define the path to the JSON file
$path = Application::$ROOT_DIR . "/src/views/layouts/sideBar.json";

// Check if the file exists
if (!file_exists($path)) {
    die("File not found: $path");
}

// Attempt to get the file contents
$pathString = file_get_contents($path);
if ($pathString === false) {
    die("Failed to read file: $path");
}

// Attempt to decode the JSON
$pathObj = json_decode($pathString);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON decode error: " . json_last_error_msg());
}

$currentLink = Application::$app->request->getPath();

if ($currentLink !== "/") {
    $currentLink = str_replace("/", "", $currentLink);
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chama Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="custom.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <?php

    if (Application::$app->session->getFlash('success')) : ?>
        <div id="flash-message" aria-live="assertive" class="pointer-events-none fixed inset-0.5 flex items-end px-4 py-6 sm:items-start sm:p-6">
            <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
                <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-green-400 shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5 text-white">
                                <?php echo Application::$app->session->getFlash('success'); ?>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button type="button" id="flash-close" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif (Application::$app->session->getFlash('error')) : ?>
        <div id="flash-message" aria-live="assertive" class="pointer-events-none fixed inset-0.5 flex items-end px-4 py-6 sm:items-start sm:p-6 ">
            <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
                <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-red-400 shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5 text-white">
                                <?php echo Application::$app->session->getFlash('error'); ?>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button type="button" id="flash-close" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <img class="" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
        </a>
        <ul class="side-menu">
            <?php foreach ($pathObj as $key) : ?>
                <?php
                // Determine if the current item is active
                $activeClass = ($key->link === $currentLink) ? 'active' : '';
                ?>
                <li class="<?= $activeClass ?>">
                    <a href="<?= htmlspecialchars($key->link, ENT_QUOTES, 'UTF-8') ?>">
                        <i class="<?= htmlspecialchars($key->icon, ENT_QUOTES, 'UTF-8') ?>"></i>
                        <?= htmlspecialchars($key->name, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="sideMenu">
                <i class='bx bx-menu'></i>
            </div>
            <div class="flex gap-8">
                <a href="#" class="notif">
                    <i class='bx bx-bell'></i>
                    <span class="count">12</span>
                </a>
                <a href="#" class="profile">
                    <img src="images/logo.png">
                </a>
            </div>
        </nav>

        <!-- End of Navbar -->

        <main>

            {{content}}

        </main>

        <script src="index.js"></script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>