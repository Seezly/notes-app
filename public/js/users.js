const $btnRestoreUsers = document.querySelectorAll(
	"[commandfor='restore-user-confirm']",
);
const $btnRestoreAction = document.querySelector("[data-action='Restore']");

if ($btnRestoreUsers) {
	$btnRestoreUsers.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			const noteId = btn.getAttribute("data-id");
			$btnRestoreAction.setAttribute("data-id", noteId);
		});
	});
}

if ($btnRestoreAction) {
	$btnRestoreAction.addEventListener("click", (e) => {
		const id = $btnRestoreAction.dataset.id;
		const token = $btnRestoreAction.dataset.token;

		fetch("/api/users", {
			method: "PATCH",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				id: id,
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
}
