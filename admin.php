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

/** @var array $user */
$user = GetCurrentUser();

if ($user["status"] == "Ban") {
    header("Location: /Instagram_Clone/banUser.php");
    exit;
}

/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var UserController $userController */
$userController = new UserController();

/** @var PostController $postController */
$postController = new PostController();

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
                <h2 class="text-xl font-medium text-neutral-800 dark:text-white">Users</h2>

                <span class="px-3 py-1 text-lg text-blue-600 bg-blue-100 rounded-full dark:bg-neutral-800 dark:text-blue-400"><?= count($allUser) ?> users</span>
            </div>

            <div class="flex justify-center items-center p-4">
                <canvas id="userChart" class="w-100 h-100"></canvas>
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
                                            <tr class="<?= $user["status"] == "Active" ? "" : "bg-red-900" ?>">
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
                                                        <?php if ($user["status"] == "Active"): ?>
                                                            <button user-id="<?= $user["id"] ?>" class="ban-user text-neutral-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-neutral-300 hover:text-red-500 focus:outline-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="24" height="24">
                                                                    <path fill="white" d="M431.2 476.5L163.5 208.8C141.1 240.2 128 278.6 128 320C128 426 214 512 320 512C361.5 512 399.9 498.9 431.2 476.5zM476.5 431.2C498.9 399.8 512 361.4 512 320C512 214 426 128 320 128C278.5 128 240.1 141.1 208.8 163.5L476.5 431.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320z" />
                                                                </svg>
                                                            </button>
                                                        <?php else: ?>
                                                            <button user-id="<?= $user["id"] ?>" class="un-ban-user text-neutral-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-neutral-300 hover:text-red-500 focus:outline-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="24" height="24">
                                                                    <path fill="white" d="M256 160C256 124.7 284.7 96 320 96C351.7 96 378 119 383.1 149.3C386 166.7 402.5 178.5 420 175.6C437.5 172.7 449.2 156.2 446.3 138.7C436.1 78.1 383.5 32 320 32C249.3 32 192 89.3 192 160L192 224C156.7 224 128 252.7 128 288L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 288C512 252.7 483.3 224 448 224L256 224L256 160z" />
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?>
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
                <h2 class="text-xl font-medium text-neutral-800 dark:text-white">Posts</h2>

                <span class="px-3 py-1 text-lg text-blue-600 bg-blue-100 rounded-full dark:bg-neutral-800 dark:text-blue-400"><?= count($allPost) ?> posts</span>
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

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-200 dark:divide-neutral-700 dark:bg-neutral-900">
                                    <?php if (!empty($allPost)): ?>
                                        <?php foreach ($allPost as $post): ?>
                                            <tr class="<?= $post["status"] == "Active" ? "" : "bg-red-900" ?>">
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

    <script src="/Instagram_Clone/assets/code/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userChart').getContext('2d');

        const userChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Active Users', 'Banned Users'],
                datasets: [{
                    data: [<?= $userController->activeCount() ?>, <?= $userController->banCount() ?>],
                    backgroundColor: ['#007BFF', '#DC143C'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>