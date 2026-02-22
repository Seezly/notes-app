const $btnRestoreUsers = document.querySelectorAll(
    "[commandfor='restore-user-confirm']",
);

if ($btnRestoreUsers) {
    if ($btnRestoreUsers) {
        $btnRestoreUsers.forEach(($btn) => {
            $btn.addEventListener("click", (e) => {
                const id = $btn.dataset.id;
                const token = $btn.dataset.token;

                fetch("/users", {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        user_id: id,
                        csrf_token: token,
                        _method: "PATCH",
                    }),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            window.location.reload();
                        }
                    });
            });
        });
    }
}
