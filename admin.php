<?php

require_once __DIR__ . "/src/helpers.php";
require_once __DIR__ . "/src/controllers/MessageController.php";
require_once __DIR__ . "/src/controllers/UserController.php";
require_once __DIR__ . "/src/controllers/AuthController.php";
require_once __DIR__ . "/src/controllers/PostController.php";

session_start();

if (empty($_SESSION) || empty($_SESSION["id"])) {
    header("Location: signUp.php");
    exit;
}

if (!empty($_POST) && !empty($_POST["logout"])) (new AuthController)->logOut();

/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var UserController $userController */
$userController = new UserController();

/** @var PostController $postController */
$postController = new PostController();

/** @var array $user */
$user = GetCurrentUser();

/** @var array $allUser */
$allUser = $userController->getAllUsers();

/** @var array $allUser */
$allPost = $postController->getAllPostsForAdmin();

if ($user["role"] !== "Admin") {
    header("Location: /Instagram_Clone/notFound.php");
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

    <div class="flex justify-center flex-col mt-5 text-white">
        <h1 class="text-3xl font-bold text-center">Admin Panal</h1>

        <section class="container px-4 mx-auto w-300">
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-neutral-800 dark:text-white">Users</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-neutral-800 dark:text-blue-400"><?= count($allUser) ?> users</span>
            </div>

            <div class="flex flex-col mt-6">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-neutral-200 dark:border-neutral-700 md:rounded-lg">
                            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                                <thead class="bg-neutral-50 dark:bg-neutral-800">
                                    <tr>
                                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Name</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Role</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Email address</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Followers</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Posts</th>

                                        <th scope="col" class="relative py-3.5 px-4">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-200 dark:divide-neutral-700 dark:bg-neutral-900">
                                    <?php if (!empty($allUser)): ?>
                                        <?php foreach ($allUser as $user): ?>
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium text-neutral-700 whitespace-nowrap">
                                                    <div class="inline-flex items-center gap-x-3">
                                                        <a href="/Instagram_Clone/accounts.php/<?= $user["url"] ?>" class="flex items-center gap-x-2">
                                                            <img class="object-cover w-10 h-10 rounded-full" src="<?= $user["profile_image"] ?>" alt="">
                                                            <div>
                                                                <h2 class="font-medium text-neutral-800 dark:text-white "><?= $user["username"] ?></h2>
                                                                <p class="text-sm font-normal text-neutral-600 dark:text-neutral-400"><?= $user["url"] ?></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium text-neutral-700 whitespace-nowrap">
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-100/60 dark:bg-neutral-800">
                                                        <h2 class="text-sm font-normal text-emerald-500"><?= $user["role"] ?></h2>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap"><?= $user["email"] ?></td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap"><?= $user["followers_count"] ?></td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap"><?= $user["posts_count"] ?></td>
                                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                    <div class="flex items-center gap-x-6">
                                                        <button user-id="<?= $user["id"] ?>" class="delete-user text-neutral-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-neutral-300 hover:text-red-500 focus:outline-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="container px-4 mx-auto w-300 mt-12 mb-6">
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-neutral-800 dark:text-white">Posts</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-neutral-800 dark:text-blue-400"><?= count($allPost) ?> posts</span>
            </div>

            <div class="flex flex-col mt-6">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-neutral-200 dark:border-neutral-700 md:rounded-lg">
                            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                                <thead class="bg-neutral-50 dark:bg-neutral-800">
                                    <tr>
                                        <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Caption</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Image</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">User</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Likes</th>

                                        <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-neutral-500 dark:text-neutral-400">Saves</th>

                                        <th scope="col" class="relative py-3.5 px-4">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-200 dark:divide-neutral-700 dark:bg-neutral-900">
                                    <?php if (!empty($allPost)): ?>
                                        <?php foreach ($allPost as $post): ?>
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium text-white whitespace-nowrap">
                                                    <?= $post["content"] ?>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap">
                                                    <img src="<?= $post["image"] ?>" alt="" class="w-30">
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium text-neutral-700 whitespace-nowrap">
                                                    <div class="inline-flex items-center gap-x-3">
                                                        <a href="/Instagram_Clone/accounts.php/<?= $post["url"] ?>" class="flex items-center gap-x-2">
                                                            <img class="object-cover w-10 h-10 rounded-full" src="<?= $post["profile_image"] ?>" alt="">
                                                            <div>
                                                                <h2 class="font-medium text-neutral-800 dark:text-white "><?= $post["username"] ?></h2>
                                                                <p class="text-sm font-normal text-neutral-600 dark:text-neutral-400"><?= $post["url"] ?></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap"><?= $post["likes_count"] ?></td>
                                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-300 whitespace-nowrap"><?= $post["saves_count"] ?></td>
                                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                    <div class="flex items-center gap-x-6">
                                                        <button post-id="<?= $post["id"] ?>" class="delete-user text-neutral-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-neutral-300 hover:text-red-500 focus:outline-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>