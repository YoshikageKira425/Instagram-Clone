<?php

require __DIR__ . "/src/helpers.php";

session_start();

if (empty($_SESSION) || empty($_SESSION["id"])) {
    header("Location: signUp.php");
    exit;
}

$user = GetCurrentUser();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram</title>
    <link rel="shortcut icon" href="/Instagram_Clone/assets/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="/Instagram_Clone/assets/style/output.css   ">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-black">
    <nav class="fixed left-0 top-0 h-screen w-[72px] bg-black border-r border-neutral-800 flex flex-col justify-between text-white transition-all">
        <div class="flex flex-col">
            <div class="px-4 pt-5">
                <a href="/" class="px-4 py-3 rounded-xl hover:bg-neutral-800 transition ">
                    <img class="w-auto h-8" src="./assets/images/icon.png" alt="">
                </a>
            </div>

            <ul class="space-y-2 px-2">
                <li>
                    <a href="/Instagram_Clone/index.php" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                        <svg aria-label="Home" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                            <title>Home</title>
                            <path d="M9.005 16.545a2.997 2.997 0 0 1 2.997-2.997A2.997 2.997 0 0 1 15 16.545V22h7V11.543L12 2 2 11.543V22h7.005Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="/Instagram_Clone/search.php" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                        <svg aria-label="Search" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                            <title>Search</title>
                            <path d="M19 10.5A8.5 8.5 0 1 1 10.5 2a8.5 8.5 0 0 1 8.5 8.5Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16.511" x2="22" y1="16.511" y2="22"></line>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="/Instagram_Clone/messages.php" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                        <svg aria-label="Direct" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                            <title>Direct</title>
                            <path d="M22.91 2.388a.69.69 0 0 0-.597-.347l-20.625.002a.687.687 0 0 0-.482 1.178L7.26 9.16a.686.686 0 0 0 .778.128l7.612-3.657a.723.723 0 0 1 .937.248.688.688 0 0 1-.225.932l-7.144 4.52a.69.69 0 0 0-.3.743l2.102 8.692a.687.687 0 0 0 .566.518.655.655 0 0 0 .103.008.686.686 0 0 0 .59-.337L22.903 3.08a.688.688 0 0 0 .007-.692" fill-rule="evenodd"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="/Instagram_Clone/creatingPost.php" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                        <svg aria-label="New post" class="x1lliihq x1n2onr6 x5n08af" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                            <title>New post</title>
                            <path d="M2 12v3.45c0 2.849.698 4.005 1.606 4.944.94.909 2.098 1.608 4.946 1.608h6.896c2.848 0 4.006-.7 4.946-1.608C21.302 19.455 22 18.3 22 15.45V8.552c0-2.849-.698-4.006-1.606-4.945C19.454 2.7 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.547 2 5.703 2 8.552Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="6.545" x2="17.455" y1="12.001" y2="12.001"></line>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12.003" x2="12.003" y1="6.545" y2="17.455"></line>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="/Instagram_Clone/accounts.php/<?= $user["url"] ?>" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                        <img src="<?= $user["profile_image"] ?>" alt="User" class="w-6 h-6 rounded-full">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>