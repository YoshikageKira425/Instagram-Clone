export function commentLogic() 
{
    const postContainers = document.querySelectorAll('.postContainer');

    postContainers.forEach(container => {
        const commentButton = container.querySelector('.commentButton');
        const commentsSection = container.querySelector('.commentsSection');
        const commentInput = container.querySelector('.comment');
        const postButton = container.querySelector('.post-btn');
        const commentsList = container.querySelector('.commentsList');

        if (commentButton.clickHandler)
            commentButton.removeEventListener('click', commentButton.clickHandler);

        commentButton.addEventListener('click', function (event) {
            event.preventDefault();
            commentsSection.classList.toggle('hidden');
        });

        if (postButton.clickHandler)
            postButton.removeEventListener('click', postButton.clickHandler);

        postButton.addEventListener('click', function (event) {
            event.preventDefault();

            const postId = postButton.getAttribute('post-id');
            const commentText = commentInput.value.trim();

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
                if (!data || !data.user || !data.comment) {
                    console.warn('Malformed response:', data);
                    return;
                }

                const noComments = commentsList.querySelector('.no-comments');
                if (noComments) 
                    noComments.remove();

                const commentElement = document.createElement('div');
                commentElement.innerHTML = `
                    <a href="/Instagram_Clone/accounts.php/${data.user.url}" class="font-semibold flex items-center gap-2">
                        <img src="${data.user.profile_image}" class="w-6 h-6 rounded-full" alt="">
                        ${data.user.username}
                    </a>
                    <p class="text-sm">${data.comment}</p>
                `;

                commentsList.appendChild(commentElement);
                commentInput.value = '';
            })
            .catch(error => {
                console.error('Fetch error:', error);
            })
        });
    });
}

commentLogic();