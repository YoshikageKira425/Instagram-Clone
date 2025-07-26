const overlay = document.getElementById("overlay");
const container = document.getElementById("container");
const text = document.getElementById("text");

function openOverlay(action, id)
{
    overlay.classList.remove("hidden");
    text.textContent = action.charAt(0).toUpperCase() + action.slice(1);
    container.innerHTML = "";

    const formData = new FormData();
    formData.append("action", action);
    formData.append("id", id);

    fetch('/Instagram_Clone/src/api/followers.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        data.users.forEach(d => {
            const newElement = document.createElement("a");
            newElement.className = "m-1 w-full px-4 py-3 rounded-xl hover:bg-neutral-900 transition";
            newElement.href = `/Instagram_Clone/accounts.php/${d.url}`;

            const buttonText = d.is_followed ? "Unfollow" : "Follow";
            const buttonClass = d.is_followed ? "bg-red-600 hover:bg-red-500" : "bg-blue-600 hover:bg-blue-500";

            newElement.innerHTML = `
                <div class="flex justify-between items-center">
                    <div class="flex flex-row justify-left gap-4">
                        <img src="${d.profile_image}" class="rounded-full w-8 h-8" alt="">
                        <p class="text-white text-xl font-bold">${d.username}</p>
                    </div>

                    <button class="follow-btn px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform ${buttonClass} rounded-lg focus:outline-none focus:ring focus:ring-opacity-80">${buttonText}</button>
                </div>
            `;

            const followBtn = newElement.querySelector(".follow-btn");
            followBtn.addEventListener("click", (e) => {
                e.preventDefault(); 
                e.stopPropagation(); 
                followUserAction(d.id, followBtn, d.is_followed);
            });

            container.appendChild(newElement);
        });
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}

function closeOverlay()
{
    overlay.classList.add("hidden");
}

function followUserAction(friendId, btnElement)
{
    const formData = new FormData();
    formData.append("friend_id", friendId);

    fetch("/Instagram_Clone/src/api/handleFollow.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.is_user_followed) {
            btnElement.textContent = "Unfollow";
            btnElement.classList.remove("bg-blue-600", "hover:bg-blue-500");
            btnElement.classList.add("bg-red-600", "hover:bg-red-500");
        } else {
            btnElement.textContent = "Follow";
            btnElement.classList.remove("bg-red-600", "hover:bg-red-500");
            btnElement.classList.add("bg-blue-600", "hover:bg-blue-500");
        }
    })
    .catch(error => {
        console.error('Follow action failed:', error);
    });
}
