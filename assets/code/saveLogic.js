document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.save-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const postId = button.getAttribute('data-post-id');
            const saved = button.getAttribute('data-liked') === '1';

            const savedIcon = `
<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <title>Saved</title>
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2px" d="M20 21 12 13.44 4 21 4 3 20 3 20 21z"></path>
                                </svg>`;

            const unSavedIcon = `
<svg aria-label="Remove" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24">
                                    <title>Unsave</title>
                                    <path d="M20 22a.999.999 0 0 1-.687-.273L12 14.815l-7.313 6.912A1 1 0 0 1 3 21V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1Z"></path>
                                </svg>`;

            const formData = new FormData();
            formData.append('post_id', postId);

            fetch('/Instagram_Clone/src/api/save.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.likes !== undefined) {
                    button.setAttribute('data-liked', saved ? '0' : '1');

                    const iconContainer = button.querySelector('.save-icon');
                    if (iconContainer) {
                        iconContainer.innerHTML = saved ? savedIcon : unSavedIcon;
                    }
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
            });
        });
    });
});