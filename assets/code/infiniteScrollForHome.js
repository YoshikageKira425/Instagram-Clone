let offset = 5;
const limit = 5;
let loading = false;
const container = document.getElementById("posts-container");

window.addEventListener("scroll", () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 300 && !loading) 
    {
        loading = true;

        const formData = new FormData();
        formData.append('offset', offset);
        formData.append('limit', limit);

        fetch(`/Instagram_Clone/src/api/loadMore.php`, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim() === '') 
            {
                window.removeEventListener('scroll', arguments.callee);
                return;
            }

            container.insertAdjacentHTML('beforeend', html);
            offset += limit;
            loading = false;  
        })
        .catch(err => {
            console.error(err);
            loading = false; 
        });
    }
});
