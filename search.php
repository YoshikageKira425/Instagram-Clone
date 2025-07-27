<?php

require __DIR__ . "/src/helpers.php";
require __DIR__ . "/src/controllers/AuthController.php";
require_once __DIR__ . "/src/controllers/MessageController.php";

session_start();

if (empty($_SESSION) || empty($_SESSION["id"])) {
    header("Location: signUp.php");
    exit;
}

if (!empty($_POST) && !empty($_POST["logout"])) 
    (new AuthController)->logOut();

/** @var array $user */
$user = GetCurrentUser();

if ($user["status"] == "Ban"){
    header("Location: /Instagram_Clone/banUser.php");
    exit;
}

/** @var MessageController $messageController */
$messageController = new MessageController();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram</title>
    <link rel="shortcut icon" href="/Instagram_Clone/assets/images/icon.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-black">
    <?php include __DIR__ . "/src/componet/navBar.php"; ?>

    <div class="min-h-screen flex justify-center">
        <div class="flex flex-col items-center w-full">
            <div class="w-[60%] mt-10 mb-10 relative">
                <span class="absolute top-3 flex items-center pl-3">
                    <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>

                <input id="search" type="text" class="w-full py-2 pl-10 pr-4 text-neutral-700 bg-white border rounded-lg dark:bg-neutral-800 dark:text-neutral-300 dark:border-neutral-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300" placeholder="Search">
            </div>

            <div class="w-[60%]">
                <h1 class="text-2xl text-center font-semibold text-white" id="no-accounts">No accounts found</h1>
                <div class="grid grid-cols-3 gap-4 border-neutral-600 border-b pb-2 mb-4" id="result-account">
                </div>
                <h1 class="text-2xl text-center font-semibold text-white" id="no-posts">No posts found</h1>
                <div class="grid grid-cols-3 gap-2 p-4 border-neutral-600 border-b pb-2 mb-4" id="result-post">

                </div>
            </div>
        </div>
    </div>

    <script src="/Instagram_Clone/assets/code/search.js"></script>
</body>

</html>