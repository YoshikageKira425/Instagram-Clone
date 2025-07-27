<?php

require_once  __DIR__ . "/src/helpers.php";
require_once  __DIR__ . "/src/controllers/PostController.php";
require_once  __DIR__ . "/src/controllers/AuthController.php";
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

/** @var MessageController $messageController */
$messageController = new MessageController();

$_SESSION["error"] = "";
if (!empty($_POST) && !empty($_POST["content"]) && !empty($_FILES)) (new PostController)->insertNewPost($_POST, $_FILES);

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

<body class="bg-black text-white">
    <?php include __DIR__ . "/src/componet/navBar.php"; ?>

    <div class="min-h-screen flex justify-center gap-4">
        <form method="post" class="w-[30%]" enctype="multipart/form-data">
            <?php if (!empty($_SESSION["error"])): ?>
                <h2 class="text-base font-medium text-red-600 mb-6"><?= $_SESSION["error"] ?></h2>
            <?php endif; ?>

            <div class="mt-4">
                <div class="w-full mt-10">
                    <label for="file" class="block text-center text-lg font-semibold text-neutral-300">File</label>

                    <label for="dropzone-file" class="flex flex-col items-center w-full p-5 mt-2 text-center bg-white border-2 border-neutral-300 border-dashed cursor-pointer dark:bg-neutral-900 dark:border-neutral-700 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-neutral-500 dark:text-neutral-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>

                        <h2 class="mt-1 font-medium tracking-wide text-neutral-700 dark:text-neutral-200">Photo File</h2>

                        <p class="mt-2 text-xs tracking-wide text-neutral-500 dark:text-neutral-400">Upload or darg & drop your file SVG, PNG or JPG. </p>

                        <input name="file" id="dropzone-file" type="file" class="text-center text-neutral-400" />
                    </label>
                </div>

                <div id="image-preview" class="mt-4 hidden">
                    <p class="text-sm text-neutral-400 mb-2">Image Preview:</p>
                    <img id="preview-img" src="" alt="Preview" class="max-w-full h-auto rounded-xl border border-neutral-700" />
                </div>

                <div class="text-center flex flex-col mt-10">
                    <label for="content" class="text-lg font-semibold text-white">Caption</label>

                    <textarea name="content" id="content" placeholder="Caption..." class=" mt-2 w-full placeholder-neutral-400/70 dark:placeholder-neutral-500 rounded-lg border border-neutral-200 bg-white px-4 h-32 py-2.5 text-neutral-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-300 dark:focus:border-blue-300"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-6 py-2 font-medium text-white transition-colors duration-300 transform bg-neutral-900 rounded-md hover:bg-neutral-800 dark:hover:bg-neutral-700 focus:outline-none focus:bg-neutral-800 dark:focus:bg-neutral-700">Post</button>
            </div>
        </form>
    </div>

    <script>
        const fileInput = document.getElementById("dropzone-file");
        const previewContainer = document.getElementById("image-preview");
        const previewImage = document.getElementById("preview-img");

        fileInput.addEventListener("change", function() {
            const file = this.files[0];

            if (!file) {
                previewContainer.classList.add("hidden");
                previewImage.src = "";
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        });
    </script>
</body>

</html>