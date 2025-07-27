let currentPage = 1;
const limit = 5;
const container = document.getElementById("posts-container");
const pagination = document.getElementById("pagination");
updatePaginationUI();

function loadPage(page) {
    container.innerHTML = "";
    const offset = (page - 1) * limit;
    const formData = new FormData();
    formData.append('offset', offset);
    formData.append('limit', limit);

    fetch('/Instagram_Clone/src/api/loadContent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        container.innerHTML = html;
        currentPage = page;
        updatePaginationUI();
    })
    .catch(err => {
        console.error("Pagination fetch failed:", err);
    });
}

function updatePaginationUI() {
    document.querySelectorAll(".page-btn").forEach(btn => {
        const page = btn.getAttribute("data-page");
        if (parseInt(page) === currentPage) {
            btn.classList.add("bg-blue-500", "text-white");
            btn.classList.remove("text-neutral-200", "bg-neutral-800");
        } else {
            btn.classList.remove("bg-blue-500", "text-white");
            btn.classList.add("text-neutral-200", "bg-neutral-800");
        }
    });
}

pagination.addEventListener("click", (e) => {
    if (!e.target.classList.contains("page-btn")) return;

    const value = e.target.getAttribute("data-page");

    if (value === "next") {
        loadPage(currentPage + 1);
    } else if (value === "prev") {
        if (currentPage > 1) loadPage(currentPage - 1);
    } else {
        const page = parseInt(value);
        if (!isNaN(page)) loadPage(page);
    }
});
