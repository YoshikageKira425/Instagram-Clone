document.addEventListener("DOMContentLoaded", function() {
    const friendButtons = document.querySelectorAll("button[friend-id]");

    const noConversation = document.getElementById("noConversation");

    const messagesContainer = document.getElementById("messagesContainer");
    const messagesList = document.getElementById("messagesList");
    const noMessages = document.getElementById("noMessages");

    const conversationImage = document.getElementById("conversationImage");
    const conversationName = document.getElementById("conversationName");

    friendButtons.forEach(button => {
        button.addEventListener("click", function() {
            const friendId = this.getAttribute("friend-id");
            
            const data = new FormData();
            data.append("friend_id", friendId);
            
            fetch("/Instagram_Clone/src/api/selectFriend.php", {
                method: "POST",
                body: data
            }).then(response => response.json())
            .then(data => {
                messagesContainer.classList.remove("hidden");
                messagesList.innerHTML = "";
                noConversation.classList.add("hidden");

                conversationImage.src = data.conversationWith.profile_image;
                conversationName.textContent = data.conversationWith.username;

                if (data.messages.length > 0)
                {
                    noMessages.classList.remove("hidden");
                    data.messages.forEach(message => {
                        const messageElement = document.createElement("div");
                        messageElement.className = `flex items ${message.sentBy === data.currentUser["id"] ? 'justify-end' : 'justify-start'} mb-3`;
                        messageElement.innerHTML = `
                            <div class="max-w-xs px-4 py-2 rounded-lg ${ message["sentBy"] === data.currentUser["id"] ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white' }">
                                <div class="flex items-center gap-2 mb-1">
                                    ${message["sentBy"] !== data.currentUser["id"] ? `
                                            <img src="${ message["profile_image"] }" class="w-8 h-8 rounded-full">
                                            <p>${message["message"]}</p>
                                        ` : `
                                            <p>${message["message"]}</p>
                                            <img src="${ message["profile_image"] }" class="w-8 h-8 rounded-full">
                                        `
                                    }
                                </div>
                                <div class="flex ${ message["sentBy"] === data.currentUser["id"] ? 'justify-end' : 'justify-start' }">
                                    <span class="text-xs text-gray-400"><?= date("H:i", strtotime($message["created_at"])) ?></span>
                                </div>
                            </div>
                        `;

                        messagesList.appendChild(messageElement);
                    });
                }
                else
                    noMessages.classList.add("hidden");
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
});