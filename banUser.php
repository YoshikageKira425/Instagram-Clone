<?php
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Ban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="/Instagram_Clone/assets/images/icon.png" type="image/x-icon">
</head>

<body>
    <section class="bg-white dark:bg-neutral-900 ">
        <div class="container flex items-center min-h-screen px-6 py-12 mx-auto">
            <div class="flex flex-col items-center max-w-sm mx-auto text-center">
                <p class="p-3 text-sm font-medium text-red-500 rounded-full bg-red-50 dark:bg-neutral-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </p>
                <h1 class="mt-3 text-2xl font-semibold text-neutral-800 dark:text-white md:text-3xl">This user is banned</h1>

                <div class="flex items-center w-full mt-6 gap-x-3 shrink-0 sm:w-auto">
                    <a href="signUp.php" class="w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-red-500 rounded-lg shrink-0 sm:w-auto hover:bg-red-600 dark:hover:bg-red-500 dark:bg-red-600">
                        Take me sign up
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>