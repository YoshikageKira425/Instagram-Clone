<?php

require_once __DIR__ . "/src/helpers.php";
require_once __DIR__ . "/src/controllers/PostController.php";
require_once __DIR__ . "/src/controllers/UserController.php";
require_once __DIR__ . "/src/controllers/AuthController.php";
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

/** @var PostController $postController */
$postController = new PostController();

/** @var UserController $userController */
$userController = new UserController();

/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var array $urlUser */
$urlUser = GetUserUrl(GetTheUrlValue());

/** @var array $post */
$post = $postController->getPosts($urlUser["id"]);

/** @var int $postCount */
$postCount = count($post);

/** @var array $accounts */
$accounts = [];

if ($urlUser["id"] === $user["id"]) {
    $whatTypeOfPosts = GetTheUrlValue(3);

    if (!empty($whatTypeOfPosts)) {
        if ($whatTypeOfPosts === "likes")
            $post = $postController->getLikedPosts($user["id"]);
        else if ($whatTypeOfPosts === "saved")
            $post = $postController->getSavedPosts($user["id"]);
        else {
            header("Location: /Instagram_Clone/notFound.php");
            exit;
        }
    }
} else {
    header("Location: /Instagram_Clone/notFound.php");
    exit;
}

if ($urlUser["status"] == "Ban")
{
    header("Location: /Instagram_Clone/notFound.php");
    exit;
}

/** @var bool @isFollowedToSomeone */
$isFollowedToSomeone = $userController->isFollowedToSomeone($user["id"], $urlUser["id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["follow_action"]))
    $userController->handleFollowAction($_POST["follow_action"], $user["id"], $urlUser["id"]);

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
        <div class="flex flex-col items-center space-y-6 mt-16">
            <div class="flex flex-row items-center space-x-10">
                <div>
                    <img src="<?= $urlUser["profile_image"] ?>" alt="User" class="w-37 h-37 rounded-full">
                </div>
                <div class="flex flex-col space-y-4">
                    <div class="flex space-x-7 items-center">
                        <p class="text-xl px-4 py-2 text-center font-semibold text-white"><?= $urlUser["username"] ?></p>
                        <?php if ($user["id"] == $urlUser["id"]): ?>
                            <a href="/Instagram_Clone/accountEdit.php" class="text-lg text-white px-4 py-2 rounded-lg bg-neutral-700 hover:bg-neutral-600 transition">Edit Profile</a>
                        <?php else: ?>
                            <form class="px-4 py-4" method="post">
                                <?php if ($isFollowedToSomeone == false): ?>
                                    <button name="follow_action" value="followed" class="text-lg text-white px-4 py-2 rounded-lg bg-neutral-700 hover:bg-neutral-600 transition">
                                        Follow
                                    </button>
                                <?php else: ?>
                                    <button name="follow_action" value="unfollowed" class="text-lg text-white px-4 py-2 rounded-lg bg-neutral-700 hover:bg-neutral-600 transition">
                                        Unfollow
                                    </button>
                                    <a href="/Instagram_Clone/messages.php" class="text-lg text-white px-4 py-2 rounded-lg bg-neutral-700 hover:bg-neutral-600 transition">Message</a>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="flex space-x-14">
                        <p class="text-base font-semibold text-neutral-400"><b class="text-white"><?= $postCount ?></b> posts</p>
                        <button onclick='openOverlay("followers", <?= $urlUser["id"] ?>)' class="cursor-pointer text-base font-semibold text-neutral-400"><b class="text-white"><?= $userController->getFollowerCount($urlUser["id"]) ?></b> followers</button>
                        <button onclick='openOverlay("following", <?= $urlUser["id"] ?>)' class="cursor-pointer text-base font-semibold text-neutral-400"><b class="text-white"><?= $userController->getFollowingCount($urlUser["id"]) ?></b> following</button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center space-x-10">
                <hr class="border-t-2 border-white">

                <div class="flex space-x-15">
                    <a href="/Instagram_Clone/accounts.php/<?= $urlUser["url"] ?>" class="text-white px-2 py-2 rounded-lg bg-black hover:bg-neutral-800 transition border-white border-b-3">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="xfx01vb" style="--color: rgb(var(--ig-primary-icon));">
                            <title>Posts</title>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M3 3H21V21H3z"></path>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M9.01486 3 9.01486 21"></path>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M14.98514 3 14.98514 21"></path>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M21 9.01486 3 9.01486"></path>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M21 14.98514 3 14.98514"></path>
                        </svg>
                    </a>

                    <?php if ($user["id"] == $urlUser["id"]): ?>
                        <a href="/Instagram_Clone/accounts.php/<?= $urlUser["url"] ?>/likes" class="text-white px-2 py-2 rounded-lg bg-black hover:bg-neutral-800 transition border-white border-b-3">
                            <svg aria-label="Like" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                <title>Like</title>
                                <path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"></path>
                            </svg>
                        </a>

                        <a href="/Instagram_Clone/accounts.php/<?= $urlUser["url"] ?>/saved" class="text-white px-2 py-2 rounded-lg bg-black hover:bg-neutral-800 transition border-white border-b-3">
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" style="--color: rgb(var(--ig-secondary-icon));">
                                <title>Saved</title>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M20 21 12 13.44 4 21 4 3 20 3 20 21z"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex flex-row items-center space-x-4">
                    <?php if (!empty($post)): ?>
                        <div class="grid grid-cols-3 gap-2 p-4">
                            <?php foreach ($post as  $p): ?>
                                <a href="/Instagram_Clone/post.php/<?= $p["id"] ?>" class="relative block w-[200px] h-[280px] overflow-hidden group">
                                    <img src="<?= $p["image"] ?>" alt="Post 1" class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-[rgba(0,0,0,0.6)] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                        <span class="text-white text-lg font-semibold">View Post</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <h1 class="text-white font-bold text-center text-2xl">No Posts Yet.</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="overlay" class="fixed z-30 top-0 w-full h-screen bg-[rgba(0,0,0,0.8)] flex justify-center items-center hidden" onclick="closeOverlay()">
        <div class="w-130 h-80 bg-neutral-800 rounded-3xl text-white">
            <h1 class="text-center text-lg font-semibold mb-3 mt-2" id="text"></h1>
            <hr class="text-neutral-600">

            <div class="flex flex-col overflow-hidden group" id="container">
            </div>
        </div>
    </div>

    <script src="/Instagram_Clone/assets/code/accounts.js"></script>
</body>

</html>