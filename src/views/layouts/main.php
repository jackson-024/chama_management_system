<?php

use app\core\Application; ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chama Management System</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
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

    {{content}}


    <script>
        // Get the flash message element
        const flashMessage = document.getElementById("flash-message");

        // Check if the flash message element exists
        if (flashMessage) {
            console.log("hhhdd");

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
    </script>
    <script src="index.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>