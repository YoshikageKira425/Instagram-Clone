document.addEventListener('DOMContentLoaded', () =>{
    const searchInput = document.getElementById('search');
    const noAccountsText = document.getElementById('no-accounts');
    const noPostsText = document.getElementById('no-posts');

    const resultAccuntContainer = document.getElementById('result-account');
    const resultPostContainer = document.getElementById('result-post');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        if (query.length !== 0) {
            const formData = new FormData();
            formData.append('query', query);

            fetch(`/Instagram_Clone/src/api/search.php`, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                resultAccuntContainer.innerHTML = '';
                resultPostContainer.innerHTML = '';

                if (data.users && data.users.length > 0) {
                    noAccountsText.style.display = 'none';
                    data.users.forEach(user => {
                        const accountElement = document.createElement('a');
                        accountElement.href = `/Instagram_Clone/accounts.php/${user.url}`;
                        accountElement.className = 'flex justify-center gap-4 px-4 py-3 rounded-xl hover:bg-neutral-800 transition';
                        accountElement.innerHTML = `
                            <img src="${user.profile_image}" class="rounded-full w-8 h-8" alt="">
                            <p class="text-white text-xl font-bold">${user.username}</p>
                        `;
                        resultAccuntContainer.appendChild(accountElement);
                    });
                }
                else
                    noAccountsText.style.display = 'block';

                if (data.posts && data.posts.length > 0) {
                    noPostsText.style.display = 'none';
                    data.posts.forEach(post => {
                        const postElement = document.createElement('a');
                        postElement.href = `/Instagram_Clone/post.php/${post.id}`;
                        postElement.className = 'relative block w-[200px] h-[280px] overflow-hidden group';
                        postElement.innerHTML = `
                            <img src="${post.image}" alt="Post 1" class="w-full h-full object-cover">

                            <div class="absolute inset-0 bg-[rgba(0,0,0,0.6)] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                <span class="text-white text-lg font-semibold">View Post</span>
                            </div>
                        `;
                        resultPostContainer.appendChild(postElement);
                    });
                }
                else
                    noPostsText.style.display = 'block';
            })
            .catch(error => {
                console.error('Search Error:', error);
            });
        }
        else
        {
            noPostsText.style.display = 'none';
            noAccountsText.style.display = 'none';
            resultAccuntContainer.innerHTML = '';
            resultPostContainer.innerHTML = '';
        }
    });
});