document.addEventListener('DOMContentLoaded', function() {
    const commentsSection = document.getElementById('commentsSection');
    const commentButton = document.getElementById('commentButton');

    const commentInput = document.getElementById('comment');
    const postButton = document.getElementById('post-btn');

    commentButton.addEventListener('click', function(event) {
        event.preventDefault();
        commentsSection.classList.toggle('hidden');
    });

    postButton.addEventListener('click', function(event) {
        const postId = postButton.getAttribute('post-id');
        const commentText = commentInput.value;

        if (!commentText || !postId) {
            console.warn("Empty comment or missing post ID");
            return;
        }

        const formData = new FormData();
        formData.append('content', commentText);
        formData.append('id', postId);

        fetch('/Instagram_Clone/src/api/comment.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            const commentElement = document.createElement('div');
            commentElement.innerHTML = `
                <a href="/Instagram_Clone/accounts.php/${data.user.url}" class="font-semibold flex">
                    <img src="${data.user.profile_image}" class="w-6 h-6 rounded-full" alt="">
                    ${data.user.username}
                </a>
                <p class="text-sm">${data.comment}</p>
            `;

            document.getElementById("commentsList").appendChild(commentElement);
            commentInput.value = ''; 
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    });
});