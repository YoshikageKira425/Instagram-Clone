<?php

declare(strict_types=1);

require_once __DIR__ . "/src/helpers.php";
require_once __DIR__ . "/src/controllers/AuthController.php";
require_once __DIR__ . "/src/controllers/UserController.php";
require_once __DIR__ . "/src/controllers/MessageController.php";

session_start();

if (empty($_SESSION) || empty($_SESSION["id"])) {
    header("Location: signUp.php");
    exit;
}

if (!empty($_POST) && !empty($_POST["logout"]))
    (new AuthController)->logOut();

/** @var UserController $userController */
$userController = new UserController();
/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var array $user */
$user = GetCurrentUser();

$_SESSION["security_error"] = "";
$_SESSION["photo_error"] = "";
if (!empty($_POST)) {
    if (!empty($_POST["username"]))
        $userController->updateAccountInfo($user, $_POST);

    if (!empty($_POST["currentPassword"]) && !empty($_POST["newPassword"]) && !empty($_POST["confirmPassword"]))
        $userController->updateSecurity($user, $_POST);

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

if (!empty($_FILES) && !empty($_FILES["photo"])) {
    $userController->updateProfile($user, $_FILES["photo"]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

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

    <div class=" flex justify-center mt-4">
        <div class="flex flex-col gap-10">
            <div class="px-10 flex items-center">
                <?php if (!empty($_SESSION["photo_error"])): ?>
                    <h2 class="text-base font-medium text-red-600 mb-6"><?= $_SESSION["photo_error"] ?></h2>
                <?php endif; ?>
                <form id="form-photo" class="relative" enctype="multipart/form-data" method="post">
                    <img class="h-24 w-24 rounded-full object-cover border-2 border-purple-500" src="<?= $user["profile_image"] ?>" alt="Profile photo">
                    <label for="dropzone-file" class="absolute bottom-0 right-0 bg-purple-600 rounded-full p-2 hover:bg-purple-700 transition">
                        <svg class="text-white" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8.586 11.414C8.96106 11.0391 9.46972 10.8284 10 10.8284C10.5303 10.8284 11.0389 11.0391 11.414 11.414L16 16M14 14L15.586 12.414C15.9611 12.0391 16.4697 11.8284 17 11.8284C17.5303 11.8284 18.0389 12.0391 18.414 12.414L20 14M14 8H14.01M6 20H18C19.1046 20 20 19.1046 20 18V6C20 4.89543 19.1046 4 18 4H6C4.89543 4 4 4.89543 4 6V18C4 19.1046 4.89543 20 6 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <input name="photo" id="dropzone-file" type="file" class="hidden" />
                    </label>
                </form>
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-white"><?= $user["username"] ?></h1>
                </div>
            </div>

            <form class="flex flex-col gap-10" id="form" method="post">
                <div class=" bg-neutral-800 p-4 rounded-xl">
                    <h2 class="text-center text-2xl text-white font-bold">Account Information</h2>
                    <?php if (!empty($_SESSION["account_error"])): ?>
                        <h2 class="text-base font-medium text-red-600 mb-6"><?= $_SESSION["account_error"] ?></h2>
                    <?php endif; ?>

                    <div class="mt-4">
                        <label for="username" class="block text-base font-bold text-neutral-500 dark:text-neutral-300">Username</label>

                        <input type="text" name="username" placeholder="Username" value="<?= $user["username"] ?>" class="block mt-2 w-full placeholder-neutral-400/70 dark:placeholder-neutral-500 rounded-lg border border-neutral-200 bg-white px-5 py-2.5 text-neutral-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 dark:focus:border-blue-300" />
                    </div>
                </div>

                <div class="bg-neutral-800 p-4 rounded-xl">
                    <h2 class="text-center text-2xl text-white font-bold">Security</h2>
                    <?php if (!empty($_SESSION["security_error"])): ?>
                        <h2 class="text-base font-medium text-red-600 mb-6"><?= $_SESSION["security_error"] ?></h2>
                    <?php endif; ?>

                    <div class="mt-4 flex flex-col gap-4">
                        <div>
                            <label for="currentPassword" class="block text-base font-bold text-neutral-500 dark:text-neutral-300">Current Password</label>

                            <input type="text" name="currentPassword" placeholder="Current Password..." class="block mt-2 w-full placeholder-neutral-400/70 dark:placeholder-neutral-500 rounded-lg border border-neutral-200 bg-white px-5 py-2.5 text-neutral-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 dark:focus:border-blue-300" />
                        </div>
                        <div>
                            <label for="newPassword" class="block text-base font-bold text-neutral-500 dark:text-neutral-300">New Password</label>

                            <input type="text" name="newPassword" placeholder="New Password..." class="block mt-2 w-full placeholder-neutral-400/70 dark:placeholder-neutral-500 rounded-lg border border-neutral-200 bg-white px-5 py-2.5 text-neutral-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 dark:focus:border-blue-300" />
                        </div>
                        <div>
                            <label for="confirmPassword" class="block text-base font-bold text-neutral-500 dark:text-neutral-300">Confirm Password</label>

                            <input type="text" name="confirmPassword" placeholder="Confirm Password..." class="block mt-2 w-full placeholder-neutral-400/70 dark:placeholder-neutral-500 rounded-lg border border-neutral-200 bg-white px-5 py-2.5 text-neutral-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 dark:focus:border-blue-300" />
                        </div>
                    </div>
                </div>

                <div class="bg-neutral-800 rounded-lg shadow p-6 border border-red-500/30">
                    <h2 class="text-lg font-medium text-white mb-6">Danger Zone</h2>
                    <div class="space-y-4">
                        <form class="form" method="post">
                            <p class="text-sm text-neutral-400 mb-4">Deleting your account will remove all of your data from our servers. This action cannot be undone.</p>
                            <button type="button" id="deleteButton" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete Account</button>
                        </form>
                    </div>
                </div>
            </form>

            <div class="flex justify-end space-x-4 pt-3">
                <button onclick="Cancel()" type="button" class="inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                <button onclick="Save()" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save Changes</button>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById("form");
        document.getElementById("dropzone-file").addEventListener("change", () => document.getElementById("form-photo").submit());

        document.getElementById("deleteButton").addEventListener("click", function() {
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                fetch('/Instagram_Clone/src/api/deleteAccount.php', {
                    method: 'POST',
                    body: JSON.stringify({ delete: true })
                }).then(response => {
                    if (response.ok) {
                        alert("Your account has been deleted successfully.");
                        window.location.href = '/Instagram_Clone/signUp.php';
                    } else {
                        alert("There was an error deleting your account. Please try again later.");
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert("There was an error deleting your account. Please try again later.");
                });
            }
        });

        function Cancel() {
            if (!confirm("Are you sure?"))
                return;

            form.reset();
        }

        function Save() {
            if (!confirm("Are you sure?"))
                return;

            form.submit();
        }
    </script>
</body>

</html>