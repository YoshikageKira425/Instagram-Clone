<?php

require_once __DIR__ . "/src/helpers.php";
require_once __DIR__ . "/src/controllers/AuthController.php";
require_once __DIR__ . "/src/controllers/PostController.php";
require_once __DIR__ . "/src/controllers/MessageController.php";

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

/** @var PostController $postController */
$postController = new PostController();
/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var array $posts */
$posts = $postController->getSomePosts(4);

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

    <div class="min-h-screen flex justify-center flex-col gap-4">
        <div class="flex flex-col mt-10" id="posts-container">
            <?php foreach ($posts as $post): ?>
                <div class="flex justify-center items-center gap-4 postContainer">
                    <div class="max-w-md text-white border border-neutral-800 rounded-lg shadow mb-6">
                        <div class="flex items-center justify-between px-4 py-3">
                            <a href="/Instagram_Clone/accounts.php/<?= $post["url"] ?>" class="flex items-center space-x-3">
                                <img src="<?= $post["profile_image"] ?>" alt="User" class="w-10 h-10 rounded-full object-cover">
                                <span class="font-semibold text-sm"><?= $post["username"] ?></span>
                            </a>
                        </div>

                        <a href="/Instagram_Clone/post.php/<?= $post["id"] ?>">
                            <img src="<?= $post["image"] ?>" alt="Post Image" class="w-full object-cover max-h-[500px]">
                        </a>

                        <div class="px-4 py-3">
                            <div class="flex items-center space-x-4">
                                <button class="like-button text-white" data-post-id="<?= $post["id"] ?>" data-liked="<?= $postController->isLiked($post["id"]) ? '1' : '0' ?>">
                                    <span class="like-icon">
                                        <?php if ($postController->isLiked($post["id"])): ?>
                                            <svg aria-label="Unlike" fill="currentColor" height="24" role="img" viewBox="0 0 48 48" width="24" class="text-red-500">
                                                <title>Unlike</title>
                                                <path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <svg aria-label="Like" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                                <title>Like</title>
                                                <path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </span>
                                </button>

                                <button class="commentButton" type="button">
                                    <svg aria-label="Comment" class="x1lliihq x1n2onr6 x5n08af" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                        <title>Comment</title>
                                        <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></path>
                                    </svg>
                                </button>

                                <button class="save-button text-white" data-post-id="<?= $post["id"] ?>" data-liked="<?= $postController->isSaved($post["id"]) ? '1' : '0' ?>">
                                    <span class="save-icon">
                                        <?php if ($postController->isSaved($post["id"])): ?>
                                            <svg aria-label="Remove" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                                <title>Unsave</title>
                                                <path d="M20 22a.999.999 0 0 1-.687-.273L12 14.815l-7.313 6.912A1 1 0 0 1 3 21V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1Z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                                <title>Saved</title>
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M20 21 12 13.44 4 21 4 3 20 3 20 21z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </span>
                                </button>
                            </div>
                            <p class="mt-2 text-sm font-semibold" id="like-text-<?= $post["id"] ?>"><?= $postController->GetLikesCount($post["id"]) ?> likes</p>

                            <p class="mt-1 text-sm"><span class="font-semibold"><?= $post["username"] ?></span> <?= $post["content"] ?></p>
                        </div>
                    </div>
                    <div class="w-80 bg-neutral-700 text-white rounded-lg shadow flex flex-col h-[500px] hidden commentsSection">
                        <div class="px-4 py-3 border-b border-neutral-600 font-semibold">Comments</div>
                        <div class="flex-grow overflow-y-auto px-4 py-3 space-y-3 commentsList">
                            <?php $comments = $postController->getComments($post["id"]);
                            if (!empty($comments)): ?>
                                <?php foreach ($comments as $c): ?>
                                    <div>
                                        <a href="/Instagram_Clone/accounts.php/<?= $c["url"] ?>" class="font-semibold flex">
                                            <img src="<?= $c["profile_image"] ?>" class="w-6 h-6 rounded-full" alt="">
                                            <?= $c["username"] ?>
                                        </a>
                                        <p class="text-sm"><?= $c["content"] ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <h1 class="no-comments text-white font-bold text-center text-2xl">No comments yet.</h1>
                            <?php endif; ?>
                        </div>

                        <div class="px-4 py-3 border-t border-neutral-600 flex space-x-2" method="post">
                            <input type="text" placeholder="Add a comment..." class="comment flex-grow rounded bg-neutral-800 px-3 py-2 text-white placeholder-neutral-400 focus:outline-none" />
                            <button type="submit" post-id="<?= $post["id"] ?>" class="post-btn text-blue-400 font-semibold hover:text-blue-600">Post</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="flex justify-center mb-10 mt-3" id="pagination">
            <button class="cursor-pointer page-btn px-4 py-2 mx-1 text-neutral-500 bg-white rounded-md dark:bg-neutral-800 dark:text-neutral-200" data-page="prev">Previous</button>

            <?php for ($i = 1; $i <= 5; $i++): ?>
                <button class="cursor-pointer page-btn px-4 py-2 mx-1 text-neutral-200 bg-neutral-800 rounded-md hover:bg-blue-500 hover:text-white" data-page="<?= $i ?>">
                    <?= $i ?>
                </button>
            <?php endfor; ?>

            <button class="cursor-pointer page-btn px-4 py-2 mx-1 text-neutral-700 bg-white rounded-md dark:bg-neutral-800 dark:text-neutral-200 hover:bg-blue-500 hover:text-white" data-page="next">Next</button>
        </div>
    </div>


    <script src="/Instagram_Clone/assets/code/home.js"></script>
    <script type="module">
        import {
            saveLogic
        } from '/Instagram_Clone/assets/code/saveLogic.js';
        import {
            likeLogic
        } from '/Instagram_Clone/assets/code/likeLogic.js';
        import {
            commentLogic
        } from '/Instagram_Clone/assets/code/commentLogic.js';

        const observer = new MutationObserver((mutationsList, observer) => {
            saveLogic();
            likeLogic();
            commentLogic();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>