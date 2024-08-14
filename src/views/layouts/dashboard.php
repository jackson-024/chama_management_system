<?php

use app\core\Application;

// check if user is authenticated
if (Application::$app->isGuest()) {
    Application::$app->response->redirect("/login");
}

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
    <link rel="stylesheet" href="custom.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="index.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<body>
    <div id="flash-message-2" aria-live="assertive" class="flash-message-container"></div>

    <?php if (Application::$app->session->getFlash('success')) : ?>
        <div id="flash-message" aria-live="assertive" class="flash-message-container">
            <div class="flash-message-wrapper">
                <div class="flash-message-box flash-message-box-success">
                    <div class="flash-message-content">
                        <div class="flash-message-inner">
                            <div class="icon-container">
                                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flash-message-text">
                                <?php echo Application::$app->session->getFlash('success'); ?>
                            </div>
                            <div class="close-button-container">
                                <button type="button" id="flash-close" class="close-button">
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
        <div id="flash-message" aria-live="assertive" class="flash-message-container">
            <div class="flash-message-wrapper">
                <div class="flash-message-box flash-message-box-error">
                    <div class="flash-message-content">
                        <div class="flash-message-inner">
                            <div class="icon-container">
                                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flash-message-text">
                                <?php echo Application::$app->session->getFlash('error'); ?>
                            </div>
                            <div class="close-button-container">
                                <button type="button" id="flash-close" class="close-button">
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
            <h2 class="main-title">CHAMAgo</h2>
        </a>
        <ul class="side-menu">
            <?php foreach ($pathObj as $key) : ?>
                <?php foreach ($key->role as $role) : ?>
                    <?php if ($role == Application::$app->session->get("user_role") || $role == 0) : ?>
                        <!-- // Determine if the current item is active -->

                        <?php $activeClass = ($key->link === $currentLink) ? 'active' : ''; ?>
                        <li class="<?= $activeClass ?>">
                            <a href="<?= htmlspecialchars($key->link, ENT_QUOTES, 'UTF-8') ?>">
                                <i class="<?= htmlspecialchars($key->icon, ENT_QUOTES, 'UTF-8') ?>"></i>
                                <?= htmlspecialchars($key->name, ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout" class="logout" onclick="clearStorage()">
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
            <div class="container">
                <?php if (Application::$app->session->get("user_role") == 1) : ?>
                    <p class="title">System Admin</p>
                <?php elseif (Application::$app->session->get("user_role") == 2) : ?>
                    <p class="title">Chairperson</p>
                <?php elseif (Application::$app->session->get("user_role") == 3) : ?>
                    <p class="title">Treasurer</p>
                <?php elseif (Application::$app->session->get("user_role") == 4) : ?>
                    <p class="title">Secretary</p>
                <?php elseif (Application::$app->session->get("user_role") == 5) : ?>
                    <p class="title">Member</p>
                <?php endif; ?>
            </div>
        </nav>

        <!-- End of Navbar -->

        <main>

            {{content}}

        </main>

        <script>
            // Get the flash message element
            const flashMessage = document.getElementById("flash-message");

            // Check if the flash message element exists
            if (flashMessage) {
                flashMessage.classList.add("animate__animated", "animate__slideInRight");

                // Set a timeout to remove the flash message after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    flashMessage.remove();
                }, 5000);
            }

            const flashClose = document.getElementById("flash-close");
            if (flashClose) {
                flashClose.addEventListener("click", () => {
                    flashMessage.remove();
                });
            }


            const menuBar = document.querySelector(".sideMenu");
            const sideBar = document.querySelector(".sidebar");

            menuBar.addEventListener("click", () => {
                if (sideBar.classList.contains("open")) {
                    sideBar.classList.remove("open");
                    sideBar.classList.add("close");
                } else {
                    sideBar.classList.remove("close");
                    sideBar.classList.add("open");
                }
            });
        </script>
</body>

</html>