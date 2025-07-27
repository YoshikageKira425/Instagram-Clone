<?php

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

/** @var array $user */
$user = GetCurrentUser();

if ($user["status"] == "Ban"){
    header("Location: /Instagram_Clone/banUser.php");
    exit;
}

/** @var UserController $userController */
$userController = new UserController();

/** @var MessageController $messageController */
$messageController = new MessageController();

/** @var array $friends */
$friends = $userController->getFollowedBy($user["id"]);

$friends = array_merge($friends, $messageController->getUsersThatTextYou());

$uniqueFriends = [];

foreach ($friends as $friend) {
    $uniqueFriends[$friend['id']] = $friend;
}

$friends = array_values($uniqueFriends);
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
    <nav class="fixed left-0 top-0 h-screen w-[72px] bg-black border-r border-neutral-800 flex flex-col justify-between text-white transition-all">
        <div class="flex flex-row">
            <div class="flex flex-col">
                <div class="px-4 pt-5">
                    <img class="w-auto h-8 ml-1" src="./assets/images/icon.png" alt="">
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
                        <a href="/Instagram_Clone/messages.php" class="relative flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                            <svg aria-label="Direct" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                <title>Direct</title>
                                <path d="M22.91 2.388a.69.69 0 0 0-.597-.347l-20.625.002a.687.687 0 0 0-.482 1.178L7.26 9.16a.686.686 0 0 0 .778.128l7.612-3.657a.723.723 0 0 1 .937.248.688.688 0 0 1-.225.932l-7.144 4.52a.69.69 0 0 0-.3.743l2.102 8.692a.687.687 0 0 0 .566.518.655.655 0 0 0 .103.008.686.686 0 0 0 .59-.337L22.903 3.08a.688.688 0 0 0 .007-.692" fill-rule="evenodd"></path>
                            </svg>
                            <?php if ($messageController->newMessages($user['id'])): ?>
                                <span class="absolute bottom-4 left-9 block h-2 w-2 rounded-full bg-red-500"></span>
                            <?php endif; ?>
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
                    <?php if ($user["role"] === "Admin"): ?>
                        <li>
                            <a href="/Instagram_Clone/admin.php" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="<?= $path === "admin.php" ? "30" : "28" ?>">
                                    <path fill="white" d="M320 312C253.7 312 200 258.3 200 192C200 125.7 253.7 72 320 72C386.3 72 440 125.7 440 192C440 258.3 386.3 312 320 312zM289.5 368L350.5 368C360.2 368 368 375.8 368 385.5C368 389.7 366.5 393.7 363.8 396.9L336.4 428.9L367.4 544L368 544L402.6 405.5C404.8 396.8 413.7 391.5 422.1 394.7C484 418.3 528 478.3 528 548.5C528 563.6 515.7 575.9 500.6 575.9L139.4 576C124.3 576 112 563.7 112 548.6C112 478.4 156 418.4 217.9 394.8C226.3 391.6 235.2 396.9 237.4 405.6L272 544.1L272.6 544.1L303.6 429L276.2 397C273.5 393.8 272 389.8 272 385.6C272 375.9 279.8 368.1 289.5 368.1z" />
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <form method="post">
            <button name="logout" value="logout" class="font-bold p-2">Logout</button>
        </form>
    </nav>

    <div class="flex ml-17 flex-row h-screen">
        <div class="border-r border-neutral-800 h-screen w-90 flex flex-col text-white">
            <div class="px-4 pt-6 pb-2 border-b border-neutral-800">
                <h1 class="font-bold text-xl"><?= $user["username"] ?></h1>
                <p class="text-sm text-neutral-500">Friends</p>
            </div>
            <?php if (!empty($friends)): ?>
                <div class="flex-1 overflow-y-auto px-4 py-2 space-y-3">
                    <?php foreach ($friends as $friend): ?>
                        <button friend-id="<?= $friend["id"] ?>" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition">
                            <img src="<?= $friend["profile_image"] ?>" alt="<?= $friend["username"] ?>" class="w-8 h-8 rounded-full">
                            <div class="flex jutify-left flex-col">
                                <span class="text-left"><?= $friend["username"] ?></span>
                                <p class="text-xs text-neutral-500 <?= $messageController->newMessage($user["id"], $friend["id"]) ? '' : 'hidden' ?>" id="new-message">New Message</p>
                            </div>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex justify-center items-center h-full">
                    <p class="text-gray-400">No friends found.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex justify-center items-center h-screen w-full" id="noConversation">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-white mb-4">Messages</h1>
                <p class="text-gray-400">Start a conversation!</p>
            </div>
        </div>

        <div class="h-screen w-full flex flex-col text-white hidden" id="messagesContainer">
            <div class="px-4 py-3 border-b border-neutral-800 flex items-center">
                <img src="" class="w-14 h-14 rounded-full mr-3" id="conversationImage">
                <h1 class="text-xl font-semibold" id="conversationName"></h1>
            </div>

            <div class="h-full overflow-y-auto px-4 py-3 flex-grow space-y-3" id="messagesList">


                <div class="flex justify-center items-center h-full" id="noMessages">
                    <p class="text-gray-400">No messages yet. Start the conversation!</p>
                </div>
            </div>

            <div class="relative w-full">
                <form method="post" class="flex items-center p-4" id="messageForm">
                    <input type="hidden" name="sentToId" id="sentToId">
                    <input type="text" name="message" id="message" placeholder="Type a message..." class="flex-grow rounded bg-neutral-800 px-3 py-2 text-white placeholder-neutral-600 focus:outline-none" required>
                    <button type="submit" class="ml-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const CURRENT_USER_ID = <?= json_encode($user["id"]) ?>;
        const CURRENT_USER_PROFILE_IMG = <?= json_encode($user["profile_image"]) ?>;

        let CURRENT_FRIEND_ID = null;

        const messagesList = document.getElementById("messagesList");
        const noMessages = document.getElementById("noMessages");
        const friendButtons = document.querySelectorAll("button[friend-id]");
        const messagesContainer = document.getElementById("messagesContainer");
        const noConversation = document.getElementById("noConversation");
        const conversationImage = document.getElementById("conversationImage");
        const conversationName = document.getElementById("conversationName");
        const form = document.getElementById("messageForm");
        const messageInput = document.getElementById("message");
        const sentToInput = document.getElementById("sentToId");
        const newMessage = document.getElementById("new-message");

        const socket = new WebSocket("ws://localhost:8090");

        socket.addEventListener("message", (event) => {
            const data = JSON.parse(event.data);

            if (data.from !== CURRENT_USER_ID && (
                    (data.from === CURRENT_FRIEND_ID && data.to === CURRENT_USER_ID) ||
                    (data.from === CURRENT_USER_ID && data.to === CURRENT_FRIEND_ID)
                )) {
                appendMessage(data);
            }

            if (data.to === CURRENT_USER_ID && CURRENT_FRIEND_ID !== data.from)
                newMessage.classList.remove("hidden");
        });

        socket.addEventListener("open", () => {
            socket.send(JSON.stringify({
                type: "register",
                from: CURRENT_USER_ID
            }));
        });
        socket.addEventListener("error", (e) => {
            console.error("WebSocket error", e);
        });
        socket.addEventListener("close", () => {
            console.warn("WebSocket closed");
        });

        function escapeHtml(text) {
            return text.replace(/[&<>"']/g, (m) => {
                return {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#39;",
                } [m];
            });
        }

        function appendMessage({
            from,
            message,
            timestamp,
            profile_image
        }) {
            noMessages.classList.add("hidden");

            const messageElement = document.createElement("div");
            messageElement.className = `flex items ${from === CURRENT_USER_ID ? "justify-end" : "justify-start"} mb-3`;
            messageElement.innerHTML = `
                    <div class="max-w-xs px-4 py-2 rounded-lg text-white ${from === CURRENT_USER_ID ? "bg-blue-600" : "bg-gray-700"}">
                        <div class="flex items-center gap-2 mb-1">
                        ${
                            from !== CURRENT_USER_ID
                            ? 
                            `<img src="${profile_image }" class="w-8 h-8 rounded-full">
                            <p>${escapeHtml(message)}</p>`
                            : 
                            `<p>${escapeHtml(message)}</p>
                            <img src="${profile_image}" class="w-8 h-8 rounded-full">`
                        }
                        </div>
                        <div class="flex ${from === CURRENT_USER_ID ? "justify-end" : "justify-start"}">
                        <span class="text-xs text-gray-400">${new Date(timestamp).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}</span>
                        </div>
                    </div>
                `;

            messagesList.appendChild(messageElement);
            messagesList.scrollTop = messagesList.scrollHeight;
        }

        friendButtons.forEach((button) => {
            button.addEventListener("click", () => {
                newMessage.classList.add("hidden");

                CURRENT_FRIEND_ID = parseInt(button.getAttribute("friend-id"));
                sentToInput.value = CURRENT_FRIEND_ID;

                conversationImage.src = button.querySelector("img").src;
                conversationName.textContent = button.querySelector("span").textContent;

                noConversation.classList.add("hidden");
                messagesContainer.classList.remove("hidden");

                messagesList.innerHTML = "";
                noMessages.classList.remove("hidden");

                loadOldMessages();
            });
        });

        form.addEventListener("submit", (e) => {
            e.preventDefault();

            const message = messageInput.value.trim();
            if (!message || !CURRENT_FRIEND_ID) return;

            const data = {
                from: CURRENT_USER_ID,
                to: CURRENT_FRIEND_ID,
                message,
                timestamp: new Date().toISOString(),
                profile_image: CURRENT_USER_PROFILE_IMG,
            };

            socket.send(JSON.stringify(data));
            appendMessage(data);

            messageInput.value = "";
        });

        function loadOldMessages() {
            const formData = new FormData();
            formData.append("friend_id", CURRENT_FRIEND_ID);

            fetch("/Instagram_Clone/src/api/getMessages.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            appendMessage({
                                from: msg.sentBy,
                                message: msg.message,
                                timestamp: msg.created_at,
                                profile_image: msg.profile_image
                            });
                        });
                        noMessages.classList.remove("hidden");
                    } else {
                        noMessages.classList.add("hidden");
                    }
                })
                .catch(err => console.error("Error loading messages:", err));
        }
    </script>
</body>

</html>