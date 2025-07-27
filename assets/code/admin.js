const banBtns = document.querySelectorAll(".ban-user");

banBtns.forEach(btn => {
    const id = btn.getAttribute("user-id");

    btn.addEventListener("click", () => {
        const dataForm = new FormData();
        dataForm.append("id", id);

        fetch("/Instagram_Clone/src/api/banAccount.php", {
            method: "POST",
            body: dataForm
        })
        .then(request => request.json())
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            console.error('AJAX Error:', error);
        });
    });
});

const unBanBtns = document.querySelectorAll(".un-ban-user");

unBanBtns.forEach(btn => {
    const id = btn.getAttribute("user-id");

    btn.addEventListener("click", () => {
        const dataForm = new FormData();
        dataForm.append("id", id);

        fetch("/Instagram_Clone/src/api/unBanAccount.php", {
            method: "POST",
            body: dataForm
        })
        .then(request => request.json())
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            console.error('AJAX Error:', error);
        });
    });
});